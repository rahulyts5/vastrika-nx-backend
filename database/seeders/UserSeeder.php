<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@vastrika.test',
            'phone' => '9876543210',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'status' => true,
            'email_verified_at' => now(),
        ]);

        // Create sample customers
        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '9123456789',
            'password' => Hash::make('password123'),
            'role' => 'customer',
            'status' => true,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'phone' => '9987654321',
            'password' => Hash::make('password123'),
            'role' => 'customer',
            'status' => true,
            'email_verified_at' => now(),
        ]);
    }
}
