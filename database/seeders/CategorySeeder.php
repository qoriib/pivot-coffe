<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Kopi', 'Non-Kopi', 'Makanan', 'Snack', 'Minuman Dingin'];

        foreach ($categories as $name) {
            Category::create(['name' => $name]);
        }
    }
}
