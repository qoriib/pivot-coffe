<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\CafeTable;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function home()
    {
        $heroTitle = 'Experience the Art of Coffee';
        $heroSubtitle = 'Dari Biji Pilihan ke Cangkir Anda';
        $tables = CafeTable::orderBy('number')->get();
        return view('landing.home', compact('heroTitle', 'heroSubtitle', 'tables'));
    }

    public function about()
    {
        $aboutTitle = 'Tentang Kami';
        $aboutText = null;
        return view('landing.about', compact('aboutTitle', 'aboutText'));
    }

    public function contact()
    {
        $email = 'hello@pivotcoffee.id';
        $phone = '+62 812-3456-7890';
        $address = '4F2W+X6 Padang MAS, Kabupaten Karo, Sumatera Utara';
        return view('landing.contact', compact('email', 'phone', 'address'));
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
