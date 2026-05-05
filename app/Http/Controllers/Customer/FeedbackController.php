<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\FeedbackRequest;
use App\Models\Feedback;
use App\Models\Order;

class FeedbackController extends Controller
{
    public function show(string $transactionId)
    {
        $order = Order::where('transaction_id', $transactionId)
            ->where('order_status', 'selesai')
            ->firstOrFail();

        if ($order->feedback) {
            return redirect()->route('customer.status', $transactionId)
                ->with('info', 'Anda sudah memberikan feedback untuk pesanan ini.');
        }

        return view('customer.feedback', compact('order'));
    }

    public function store(FeedbackRequest $request, string $transactionId)
    {
        $order = Order::where('transaction_id', $transactionId)
            ->where('order_status', 'selesai')
            ->firstOrFail();

        if ($order->feedback) {
            return redirect()->route('customer.status', $transactionId)
                ->with('info', 'Anda sudah memberikan feedback.');
        }

        Feedback::create([
            'order_id' => $order->id,
            'rating'   => $request->rating,
            'comment'  => $request->comment,
        ]);

        return redirect()->route('customer.status', $transactionId)
            ->with('success', 'Terima kasih atas feedback Anda!');
    }
}
