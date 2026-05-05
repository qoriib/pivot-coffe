<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function notification(Request $request)
    {
        try {
            \Midtrans\Config::$serverKey    = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = config('midtrans.is_production');
            \Midtrans\Config::$isSanitized  = config('midtrans.is_sanitized');
            \Midtrans\Config::$is3ds        = config('midtrans.is_3ds');

            $notification = new \Midtrans\Notification();

            $transactionStatus = $notification->transaction_status;
            $fraudStatus       = $notification->fraud_status;
            $orderId           = $notification->order_id;

            $order = Order::where('transaction_id', $orderId)->first();

            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            if ($transactionStatus === 'capture') {
                if ($fraudStatus === 'challenge') {
                    $order->update(['payment_status' => 'pending']);
                } elseif ($fraudStatus === 'accept') {
                    $order->update(['payment_status' => 'paid', 'order_status' => 'diproses']);
                }
            } elseif ($transactionStatus === 'settlement') {
                $order->update(['payment_status' => 'paid', 'order_status' => 'diproses']);
            } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                $order->update(['payment_status' => 'failed', 'order_status' => 'dibatalkan']);
            } elseif ($transactionStatus === 'pending') {
                $order->update(['payment_status' => 'pending']);
            }

            return response()->json(['message' => 'OK']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
