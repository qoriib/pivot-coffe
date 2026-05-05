<?php

namespace Database\Seeders;

use App\Models\Promo;
use Illuminate\Database\Seeder;

class PromoSeeder extends Seeder
{
    public function run(): void
    {
        Promo::create([
            'code'           => 'HEMAT10',
            'description'    => 'Diskon 10% untuk semua menu',
            'discount_type'  => 'percent',
            'discount_value' => 10,
            'is_active'      => true,
            'valid_from'     => now()->startOfYear(),
            'valid_until'    => now()->endOfYear(),
        ]);

        Promo::create([
            'code'           => 'GRATIS5K',
            'description'    => 'Potongan Rp 5.000 untuk pembelian minimum',
            'discount_type'  => 'fixed',
            'discount_value' => 5000,
            'is_active'      => true,
            'valid_from'     => now()->startOfYear(),
            'valid_until'    => now()->endOfYear(),
        ]);
    }
}
