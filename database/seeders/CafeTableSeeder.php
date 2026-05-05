<?php

namespace Database\Seeders;

use App\Models\CafeTable;
use Illuminate\Database\Seeder;

class CafeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            CafeTable::create([
                'number' => $i,
                'qr_token' => 'table-' . $i . '-' . \Illuminate\Support\Str::random(10),
            ]);
        }
    }
}
