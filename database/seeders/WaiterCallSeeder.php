<?php

namespace Database\Seeders;

use App\Models\CafeTable;
use App\Models\WaiterCall;
use Illuminate\Database\Seeder;

class WaiterCallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tables = CafeTable::all();

        if ($tables->isEmpty()) {
            return;
        }

        WaiterCall::create([
            'table_id' => $tables[4]->id,
            'status' => 'pending'
        ]);

        WaiterCall::create([
            'table_id' => $tables[5]->id,
            'status' => 'pending'
        ]);

        WaiterCall::create([
            'table_id' => $tables[0]->id,
            'status' => 'done',
            'created_at' => now()->subHours(2)
        ]);
    }
}
