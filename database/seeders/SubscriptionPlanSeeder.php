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
                'name' => 'General Mentorship',
                'description' => "Recorded Course Video\nZoom classes & practical\nOnline Mentorship\nAccess into my Inner Circle Trading Group with Co Traders\nCertification on completion",
                'duration_days' => 0, // Lifetime
                'price' => 150.00,
                'price_ngn' => 215000.00,
                'payment_link' => 'https://paystack.shop/pay/general-class-mentorship',
                'is_active' => true,
            ],
            [
                'name' => 'Exclusive Mentorship',
                'description' => "Online Mentorship\nOne-on-One Coaching\nPrivate Mentorship\nExclusive 5 weeks with a private coach\nAccess VIP Signal & Benefits\nAccess into my Inner Circle Trading Group with Co Traders\nCertification on completion",
                'duration_days' => 0, // Lifetime
                'price' => 500.00,
                'price_ngn' => 750000.00,
                'payment_link' => 'https://paystack.shop/pay/fxctradepad-exclusive-mentorship',
                'is_active' => true,
            ],
            [
                'name' => 'Physical Mentorship',
                'description' => "Physical class with a coach\nClasses & practical\nOne-on-One Coaching\nPrivate Mentorship\nExclusive 5 weeks with a private coach\nAccess VIP Signal & Benefits\nAccess into my Inner Circle Trading Group with Co Traders\nCertification on completion",
                'duration_days' => 0, // Lifetime
                'price' => 1000.00,
                'price_ngn' => 1500000.00,
                'payment_link' => 'https://paystack.shop/pay/fxctradepad-private-mentorship',
                'is_active' => true,
            ],
            [
                'name' => 'Lifetime Trade Signals',
                'description' => "Premium Monthly Signals\nSniper Entries\nMaximum 50 pips Stop Loss\n0 - 4 trades Per Day\nRisk & Money Management\n80 - 90% Accuracy\nFree Tutorials on how to take signals",
                'duration_days' => 0, // Lifetime
                'price' => 250.00, // Approximate
                'price_ngn' => 350000.00,
                'payment_link' => 'https://paystack.shop/pay/tradelikeokafor-life-time-signal',
                'is_active' => true,
            ],
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::updateOrCreate(
                ['name' => $plan['name']],
                $plan
            );
        }

        $this->command->info('Subscription plans updated successfully!');
    }
}
