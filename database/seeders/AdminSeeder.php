<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'name'     => 'Admin Pivot Caffe',
            'email'    => 'admin@coffee.com',
            'password' => Hash::make('password'),
            'role'     => 'superadmin',
        ]);
    }
}
