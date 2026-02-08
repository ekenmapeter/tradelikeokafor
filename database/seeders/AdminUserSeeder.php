<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'support@tradelikeokafor.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'phone' => '+1234567890',
                'role' => 'admin',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: support@tradelikeokafor.com');
        $this->command->info('Password: password');
    }
}
