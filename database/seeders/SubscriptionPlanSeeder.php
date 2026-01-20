<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Basic Plan',
                'description' => 'Perfect for beginners. Get access to basic trading lessons and resources.',
                'duration_days' => 30,
                'price' => 49.99,
                'payment_link' => 'https://paypal.me/example/49.99',
                'is_active' => true,
            ],
            [
                'name' => 'Premium Plan',
                'description' => 'Advanced trading strategies and live sessions. Includes all basic features plus premium content.',
                'duration_days' => 90,
                'price' => 129.99,
                'payment_link' => 'https://paypal.me/example/129.99',
                'is_active' => true,
            ],
            [
                'name' => 'VIP Plan',
                'description' => 'One-on-one mentorship, exclusive trading signals, and lifetime access to all resources.',
                'duration_days' => 365,
                'price' => 499.99,
                'payment_link' => 'https://paypal.me/example/499.99',
                'is_active' => true,
            ],
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::create($plan);
        }

        $this->command->info('Subscription plans created successfully!');
    }
}
