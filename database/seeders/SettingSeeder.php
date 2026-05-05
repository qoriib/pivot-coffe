<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'landing_hero_title', 'value' => 'Selamat Datang di Pivot Caffe'],
            ['key' => 'landing_hero_subtitle', 'value' => 'Nikmati racikan kopi terbaik dari biji pilihan Nusantara.'],
            ['key' => 'about_title', 'value' => 'Kisah Kami'],
            ['key' => 'about_text', 'value' => 'Pivot Caffe didirikan dengan semangat untuk menyajikan pengalaman minum kopi yang otentik. Kami percaya bahwa secangkir kopi yang baik dapat menghubungkan orang-orang dan menciptakan momen tak terlupakan. Tempat kami nyaman untuk bersantai, bekerja, maupun berkumpul bersama teman.'],
            ['key' => 'contact_email', 'value' => 'hello@coffee.com'],
            ['key' => 'contact_phone', 'value' => '+62 812 3456 7890'],
            ['key' => 'contact_address', 'value' => 'Jl. Kopi Nusantara No. 1, Jakarta, Indonesia'],
        ];

        foreach ($settings as $setting) {
            Setting::set($setting['key'], $setting['value']);
        }
    }
}
