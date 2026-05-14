<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['table', 'items'])->latest();

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $orders = $query->paginate(20)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function monitor()
    {
        $orders = Order::with(['table', 'items.menu'])
            ->whereIn('order_status', ['menunggu', 'diproses'])
            ->latest()
            ->get();

        return view('admin.orders.monitor', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['table', 'items.menu', 'promo', 'feedback']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'order_status' => 'required|in:menunggu,diproses,selesai,dibatalkan',
        ]);

        if ($order->payment_method !== 'cash' && $request->order_status === 'dibatalkan') {
            return back()->with('error', 'Pesanan dengan pembayaran e-wallet tidak dapat dibatalkan.');
        }

        $data = ['order_status' => $request->order_status];

        $order->update($data);

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    /**
     * Konfirmasi pembayaran oleh admin — berlaku untuk tunai dan e-wallet.
     * Saat dikonfirmasi: payment_status = paid, order_status = diproses
     */
    public function confirmPayment(Request $request, Order $order)
    {
        if ($order->payment_status === 'paid') {
            return back()->with('info', 'Pembayaran sudah dikonfirmasi sebelumnya.');
        }

        $cashReceived = null;
        $changeAmount = null;

        if ($order->payment_method === 'cash') {
            $request->validate([
                'cash_received' => 'required|numeric|min:' . $order->total,
            ], [
                'cash_received.required' => 'Uang diterima wajib diisi.',
                'cash_received.numeric' => 'Uang diterima harus berupa angka.',
                'cash_received.min' => 'Uang diterima tidak boleh kurang dari total pembayaran.',
            ]);

            $cashReceived = (float) $request->cash_received;
            $changeAmount = $cashReceived - (float) $order->total;
        }

        $order->update([
            'payment_status' => 'paid',
            'order_status'   => 'diproses',
        ]);

        $method = $order->payment_method === 'cash' ? 'Tunai' : 'E-Wallet';
        if ($order->payment_method === 'cash') {
            $receivedText = number_format($cashReceived, 0, ',', '.');
            $changeText = number_format($changeAmount, 0, ',', '.');
            return back()->with('success', "Pembayaran {$method} dikonfirmasi. Uang diterima Rp {$receivedText}, kembalian Rp {$changeText}. Pesanan mulai diproses.");
        }

        return back()->with('success', "Pembayaran {$method} dikonfirmasi. Pesanan mulai diproses.");
    }

    public function print(Order $order)
    {
        $order->load(['table', 'items.menu', 'promo']);
        return view('admin.orders.print', compact('order'));
    }
}
