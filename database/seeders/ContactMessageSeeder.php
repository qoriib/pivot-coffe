<?php

namespace Database\Seeders;

use App\Models\ContactMessage;
use Illuminate\Database\Seeder;

class ContactMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $messages = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'message' => 'Halo, saya ingin menanyakan apakah ada promo untuk reservasi grup?',
                'is_read' => false,
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'message' => 'Tempatnya sangat bagus! Kopi susunya juara.',
                'is_read' => true,
            ],
            [
                'name' => 'Budi Pratama',
                'email' => 'budi@example.com',
                'message' => 'Apakah tersedia menu vegan?',
                'is_read' => false,
            ],
        ];

        foreach ($messages as $msg) {
            ContactMessage::create($msg);
        }
    }
}
