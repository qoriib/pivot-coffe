<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WaiterCall;

class WaiterCallController extends Controller
{
    public function index()
    {
        $calls = WaiterCall::with('table')->latest()->paginate(20);
        return view('admin.waiter-calls.index', compact('calls'));
    }

    public function done(WaiterCall $waiterCall)
    {
        $waiterCall->update(['status' => 'done']);
        return back()->with('success', 'Panggilan pelayan telah ditandai selesai.');
    }
}
