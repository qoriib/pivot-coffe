<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\CheckoutRequest;
use App\Models\CafeTable;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Promo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function show(string $qrToken)
    {
        $table = CafeTable::where('qr_token', $qrToken)->firstOrFail();
        $cart = session('cart_' . $table->id, []);

        if (empty($cart)) {
            return redirect()->route('customer.menu', $qrToken)
                ->with('error', 'Keranjang kosong. Tambahkan menu terlebih dahulu.');
        }

        $today = Carbon::today();
        $promos = Promo::where('is_active', true)
            ->where('valid_from', '<=', $today)
            ->where('valid_until', '>=', $today)
            ->get();

        $subtotal = collect($cart)->sum(fn($item) => $item['unit_price'] * $item['quantity']);

        return view('customer.checkout', compact('table', 'cart', 'promos', 'subtotal'));
    }

    public function store(CheckoutRequest $request, string $qrToken)
    {
        $table = CafeTable::where('qr_token', $qrToken)->firstOrFail();
        $cart = session('cart_' . $table->id, []);

        if (empty($cart)) {
            return redirect()->route('customer.menu', $qrToken)
                ->with('error', 'Keranjang kosong.');
        }

        // Calculate subtotal
        $subtotal = collect($cart)->sum(fn($item) => $item['unit_price'] * $item['quantity']);
        $discount = 0;
        $promoId = null;

        // Validate promo
        if ($request->filled('promo_code')) {
            $today = Carbon::today();
            $promo = Promo::where('code', $request->promo_code)
                ->where('is_active', true)
                ->where('valid_from', '<=', $today)
                ->where('valid_until', '>=', $today)
                ->first();

            if (!$promo) {
                return back()->withErrors(['promo_code' => 'Kode promo tidak valid atau sudah kadaluarsa.'])
                    ->withInput();
            }

            $discount = $promo->calculateDiscount($subtotal);
            $promoId = $promo->id;
        }

        $total = $subtotal - $discount;

        // Generate transaction ID
        $transactionId = 'TRX-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(4));

        try {
            DB::beginTransaction();

            $order = Order::create([
                'transaction_id' => $transactionId,
                'table_id'       => $table->id,
                'customer_name'  => $request->customer_name,
                'promo_id'       => $promoId,
                'subtotal'       => $subtotal,
                'discount'       => $discount,
                'total'          => $total,
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'order_status'   => 'menunggu',
                'notes'          => $request->notes,
            ]);

            foreach ($cart as $menuId => $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'menu_id'    => $menuId,
                    'quantity'   => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal'   => $item['unit_price'] * $item['quantity'],
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan. Silakan coba lagi.')->withInput();
        }

        // Clear cart
        session()->forget('cart_' . $table->id);
        session(['last_transaction_id' => $transactionId]);

        // Handle payment method
        // E-wallet diperlakukan sama seperti tunai — konfirmasi manual oleh admin
        // Midtrans payment gateway dinonaktifkan sementara
        $successMsg = $request->payment_method === 'ewallet'
            ? 'Pesanan berhasil dibuat. Silakan tunjukkan bukti transfer e-wallet ke kasir.'
            : 'Pesanan berhasil dibuat. Silakan lakukan pembayaran ke kasir.';

        return redirect()->route('customer.status', $transactionId)
            ->with('success', $successMsg);
    }

    /*
    |--------------------------------------------------------------------------
    | processEwallet — Midtrans Payment Gateway (dinonaktifkan sementara)
    | Aktifkan kembali jika ingin menggunakan Midtrans Snap untuk e-wallet
    |--------------------------------------------------------------------------
    private function processEwallet(Order $order, CafeTable $table)
    {
        try {
            \Midtrans\Config::$serverKey    = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = config('midtrans.is_production');
            \Midtrans\Config::$isSanitized  = config('midtrans.is_sanitized');
            \Midtrans\Config::$is3ds        = config('midtrans.is_3ds');

            $items = $order->items()->with('menu')->get()->map(fn($item) => [
                'id'       => (string) $item->menu_id,
                'price'    => (int) $item->unit_price,
                'quantity' => $item->quantity,
                'name'     => substr($item->menu->name, 0, 50),
            ])->toArray();

            if ($order->discount > 0) {
                $items[] = [
                    'id'       => 'DISCOUNT',
                    'price'    => -(int) $order->discount,
                    'quantity' => 1,
                    'name'     => 'Diskon Promo',
                ];
            }

            $params = [
                'transaction_details' => [
                    'order_id'     => $order->transaction_id,
                    'gross_amount' => (int) $order->total,
                ],
                'customer_details' => [
                    'first_name' => $order->customer_name,
                ],
                'item_details' => $items,
            ];

            if (env('NGROK_URL')) {
                $params['callbacks'] = [
                    'finish' => env('NGROK_URL') . '/order/status/' . $order->transaction_id,
                ];
                \Midtrans\Config::$appendNotifUrl = env('NGROK_URL') . '/payment/notification';
            }

            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $order->update(['snap_token' => $snapToken]);

            return redirect('https://app.sandbox.midtrans.com/snap/v2/vtweb/' . $snapToken);
        } catch (\Exception $e) {
            $order->update(['payment_status' => 'failed', 'order_status' => 'dibatalkan']);
            return redirect()->route('customer.status', $order->transaction_id)
                ->with('error', 'Gagal memproses pembayaran e-wallet. Silakan coba lagi.');
        }
    }
    */
}
