<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create the Administrator Account
        User::updateOrCreate(
            ['email' => 'admin@fpas.com'], // Prevent duplicating if you run the seeder twice
            [
                'name' => 'System Admin',
                'role' => 'admin',
                'password' => Hash::make('password123'), // Securely hash the password
                'email_verified_at' => now(),
            ]
        );

        // 2. Create a Test Farmer Account
        User::updateOrCreate(
            ['email' => 'farmer@fpas.com'],
            [
                'name' => 'Test Farmer',
                'role' => 'farmer',
                'phone_number' => '+27831234567', // Useful for testing the Twilio SMS later
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Test users have been seeded successfully!');
    }
}