<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            CategorySeeder::class,
            MenuSeeder::class,
            CafeTableSeeder::class,
            PromoSeeder::class,
            OrderSeeder::class,
            WaiterCallSeeder::class,
            ContactMessageSeeder::class,
        ]);
    }
}
