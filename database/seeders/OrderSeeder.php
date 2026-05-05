<?php

namespace Database\Seeders;

use App\Models\CafeTable;
use App\Models\Feedback;
use App\Models\Menu;
use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tables = CafeTable::all();
        $menus = Menu::all();

        if ($tables->isEmpty() || $menus->isEmpty()) {
            return;
        }

        // 1. Pending Order
        $order1 = Order::create([
            'transaction_id' => 'TRX-' . strtoupper(\Illuminate\Support\Str::random(10)),
            'table_id' => $tables[0]->id,
            'customer_name' => 'Budi Santoso',
            'subtotal' => 50000,
            'discount' => 0,
            'total' => 50000,
            'payment_method' => 'cash',
            'payment_status' => 'pending',
            'order_status' => 'menunggu',
        ]);
        $order1->items()->create(['menu_id' => $menus[0]->id, 'quantity' => 2, 'unit_price' => $menus[0]->price, 'subtotal' => $menus[0]->price * 2]);

        // 2. Processing Order
        $order2 = Order::create([
            'transaction_id' => 'TRX-' . strtoupper(\Illuminate\Support\Str::random(10)),
            'table_id' => $tables[1]->id,
            'customer_name' => 'Siti Aminah',
            'subtotal' => 75000,
            'discount' => 5000,
            'total' => 70000,
            'payment_method' => 'ewallet',
            'payment_status' => 'paid',
            'order_status' => 'diproses',
        ]);
        $order2->items()->create(['menu_id' => $menus[1]->id, 'quantity' => 3, 'unit_price' => $menus[1]->price, 'subtotal' => $menus[1]->price * 3]);

        // 3. Completed Order (History)
        $order3 = Order::create([
            'transaction_id' => 'TRX-' . strtoupper(\Illuminate\Support\Str::random(10)),
            'table_id' => $tables[2]->id,
            'customer_name' => 'Andi Wijaya',
            'subtotal' => 120000,
            'discount' => 10000,
            'total' => 110000,
            'payment_method' => 'cash',
            'payment_status' => 'paid',
            'order_status' => 'selesai',
            'created_at' => now()->subDays(1),
        ]);
        $order3->items()->create(['menu_id' => $menus[2]->id, 'quantity' => 4, 'unit_price' => $menus[2]->price, 'subtotal' => $menus[2]->price * 4]);

        // 4. Another Completed Order with Feedback
        $order4 = Order::create([
            'transaction_id' => 'TRX-' . strtoupper(\Illuminate\Support\Str::random(10)),
            'table_id' => $tables[3]->id,
            'customer_name' => 'Rina Kartika',
            'subtotal' => 45000,
            'discount' => 0,
            'total' => 45000,
            'payment_method' => 'ewallet',
            'payment_status' => 'paid',
            'order_status' => 'selesai',
            'created_at' => now()->subHours(5),
        ]);
        $order4->items()->create(['menu_id' => $menus[3]->id, 'quantity' => 1, 'unit_price' => $menus[3]->price, 'subtotal' => $menus[3]->price]);
        
        Feedback::create([
            'order_id' => $order4->id,
            'rating' => 5,
            'comment' => 'Kopi nya enak banget, suasana nyaman!'
        ]);
    }
}
