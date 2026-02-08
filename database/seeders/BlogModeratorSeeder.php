<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BlogModeratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'moderator@tradelikeokafor.com'],
            [
                'name' => 'Blog Moderator',
                'password' => Hash::make('password'),
                'role' => 'moderator',
                'status' => 'active',
                'phone' => '08000000000',
            ]
        );
    }
}
