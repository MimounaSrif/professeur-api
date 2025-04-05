<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // ✅ Admin 1 : Achraf El Hamry
        User::updateOrCreate(
            ['email' => 'achraf@admin.com'],
            [
                'first_name' => 'Achraf',
                'last_name' => 'El Hamry',
                'cin' => 'ADMIN001',
                'phone' => '0600000000',
                'course' => 'aucun',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // ✅ Admin 2 : Générique
        User::updateOrCreate(
            ['email' => 'admin2@admin.com'],
            [
                'first_name' => 'Admin',
                'last_name' => 'Deux',
                'cin' => 'ADMIN002',
                'phone' => '0600000001',
                'course' => 'aucun',
                'password' => Hash::make('admin456'),
                'role' => 'admin',
            ]
        );
    }
}
