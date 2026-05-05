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

        $data = ['order_status' => $request->order_status];

        $order->update($data);

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    /**
     * Konfirmasi pembayaran oleh admin — berlaku untuk tunai dan e-wallet.
     * Saat dikonfirmasi: payment_status = paid, order_status = diproses
     */
    public function confirmPayment(Order $order)
    {
        if ($order->payment_status === 'paid') {
            return back()->with('info', 'Pembayaran sudah dikonfirmasi sebelumnya.');
        }

        $order->update([
            'payment_status' => 'paid',
            'order_status'   => 'diproses',
        ]);

        $method = $order->payment_method === 'cash' ? 'Tunai' : 'E-Wallet';
        return back()->with('success', "Pembayaran {$method} dikonfirmasi. Pesanan mulai diproses.");
    }

    public function print(Order $order)
    {
        $order->load(['table', 'items.menu', 'promo']);
        return view('admin.orders.print', compact('order'));
    }
}
