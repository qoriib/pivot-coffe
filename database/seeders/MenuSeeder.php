<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $kopi        = Category::where('name', 'Kopi')->first();
        $nonKopi     = Category::where('name', 'Non-Kopi')->first();
        $makanan     = Category::where('name', 'Makanan')->first();
        $snack       = Category::where('name', 'Snack')->first();
        $minumanDingin = Category::where('name', 'Minuman Dingin')->first();

        $menus = [
            // Kopi
            [
                'category_id' => $kopi->id,
                'name'        => 'Espresso',
                'description' => 'Kopi espresso murni dengan cita rasa kuat dan aroma yang khas.',
                'price'       => 18000,
            ],
            [
                'category_id' => $kopi->id,
                'name'        => 'Americano',
                'description' => 'Espresso yang diencerkan dengan air panas, menghasilkan rasa yang lebih ringan.',
                'price'       => 22000,
            ],
            [
                'category_id' => $kopi->id,
                'name'        => 'Cappuccino',
                'description' => 'Perpaduan espresso, susu kukus, dan busa susu yang lembut.',
                'price'       => 28000,
            ],
            [
                'category_id' => $kopi->id,
                'name'        => 'Latte',
                'description' => 'Espresso dengan susu kukus yang creamy dan sedikit busa di atasnya.',
                'price'       => 30000,
            ],
            // Non-Kopi
            [
                'category_id' => $nonKopi->id,
                'name'        => 'Teh Tarik',
                'description' => 'Teh susu khas dengan teknik tarik yang menghasilkan busa alami.',
                'price'       => 18000,
            ],
            [
                'category_id' => $nonKopi->id,
                'name'        => 'Matcha Latte',
                'description' => 'Bubuk matcha premium dicampur susu kukus yang creamy.',
                'price'       => 32000,
            ],
            [
                'category_id' => $nonKopi->id,
                'name'        => 'Cokelat Panas',
                'description' => 'Minuman cokelat hangat dengan susu segar pilihan.',
                'price'       => 25000,
            ],
            // Makanan
            [
                'category_id' => $makanan->id,
                'name'        => 'Nasi Goreng Spesial',
                'description' => 'Nasi goreng dengan telur, ayam, dan sayuran segar pilihan.',
                'price'       => 35000,
            ],
            [
                'category_id' => $makanan->id,
                'name'        => 'Sandwich Ayam Panggang',
                'description' => 'Roti gandum dengan ayam panggang, selada, tomat, dan saus spesial.',
                'price'       => 38000,
            ],
            [
                'category_id' => $makanan->id,
                'name'        => 'Pasta Carbonara',
                'description' => 'Pasta dengan saus krim, bacon, dan keju parmesan.',
                'price'       => 42000,
            ],
            // Snack
            [
                'category_id' => $snack->id,
                'name'        => 'Kentang Goreng',
                'description' => 'Kentang goreng renyah dengan bumbu garam dan saus pilihan.',
                'price'       => 22000,
            ],
            [
                'category_id' => $snack->id,
                'name'        => 'Croissant Butter',
                'description' => 'Croissant lapis-lapis dengan mentega premium, renyah di luar lembut di dalam.',
                'price'       => 20000,
            ],
            // Minuman Dingin
            [
                'category_id' => $minumanDingin->id,
                'name'        => 'Es Kopi Susu',
                'description' => 'Kopi susu segar dengan es batu, manis dan menyegarkan.',
                'price'       => 28000,
            ],
            [
                'category_id' => $minumanDingin->id,
                'name'        => 'Es Matcha',
                'description' => 'Matcha dingin dengan susu segar dan es batu yang menyegarkan.',
                'price'       => 30000,
            ],
            [
                'category_id' => $minumanDingin->id,
                'name'        => 'Lemon Tea Dingin',
                'description' => 'Teh dingin dengan perasan lemon segar dan sedikit madu.',
                'price'       => 20000,
            ],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}
