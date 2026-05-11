<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\CafeTable;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function home(CafeTable $table)
    {
        $heroTitle = 'Experience the Art of Coffee';
        $heroSubtitle = 'Dari Biji Pilihan ke Cangkir Anda';
        $tables = CafeTable::orderBy('number')->get();
        
        session([
            'table_id' => $table->id,
            'table_number' => $table->number,
            'qr_token' => $table->qr_token
        ]);
        
        $selectedTable = $table;

        // Updated view path to customer.home
        return view('customer.home', compact('heroTitle', 'heroSubtitle', 'tables', 'selectedTable'));
    }

    public function about()
    {
        $aboutTitle = 'Tentang Kami';
        $aboutText = null;
        // Updated view path to customer.about
        return view('customer.about', compact('aboutTitle', 'aboutText'));
    }

    public function contact()
    {
        $email = 'hello@pivotcoffee.id';
        $phone = '+62 812-3456-7890';
        $address = '4F2W+X6 Padang MAS, Kabupaten Karo, Sumatera Utara';
        // Updated view path to customer.contact
        return view('customer.contact', compact('email', 'phone', 'address'));
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        ContactMessage::create($validated);

        return back()->with('success', 'Terima kasih! Pesan Anda telah berhasil dikirim dan akan segera kami proses.');
    }
}
