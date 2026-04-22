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
        // Create the default test account
        User::create([
            'name' => 'Polla Admin',
            'email' => 'admin@pollabank.com',
            'password' => Hash::make('password123'),
            'balance' => 8000.00,
            'email_verified_at' => now(),
        ]);
    }
}
