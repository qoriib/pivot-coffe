<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\ContactMessage;
use App\Models\CafeTable;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function home()
    {
        $heroTitle = Setting::get('landing_hero_title', 'Selamat Datang');
        $heroSubtitle = Setting::get('landing_hero_subtitle', 'Nikmati kopi terbaik kami');
        $tables = CafeTable::orderBy('number')->get();
        return view('landing.home', compact('heroTitle', 'heroSubtitle', 'tables'));
    }

    public function about()
    {
        $aboutTitle = Setting::get('about_title', 'Tentang Kami');
        $aboutText = Setting::get('about_text', '');
        return view('landing.about', compact('aboutTitle', 'aboutText'));
    }

    public function contact()
    {
        $email = Setting::get('contact_email', '');
        $phone = Setting::get('contact_phone', '');
        $address = Setting::get('contact_address', '');
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
