<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            [
                // Kolom untuk pencarian
                'email' => 'admin@example.com',
            ],
            [
                // Data yang akan dibuat atau di-update
                'name' => 'Admin Pangkalan',
                'password' => Hash::make('password'), // Ganti 'password' dengan password aman Anda
                'phone_number' => '081234567890',
                'role' => 'admin',
                'status' => 'approved',
            ]
        );
    }
}
