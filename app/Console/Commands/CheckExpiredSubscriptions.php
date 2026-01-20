<?php

namespace App\Console\Commands;

use App\Models\UserSubscription;
use App\Models\User;
use App\Mail\SubscriptionExpired;
use App\Mail\SubscriptionExpiredAdmin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckExpiredSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:check-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and update expired subscriptions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for expired subscriptions...');

        // Find active subscriptions that have passed their end date
        $expiredSubscriptions = UserSubscription::where('status', 'active')
            ->where('end_date', '<', now())
            ->get();

        if ($expiredSubscriptions->isEmpty()) {
            $this->info('No expired subscriptions found.');
            return 0;
        }

        $count = 0;
        foreach ($expiredSubscriptions as $subscription) {
            // Update subscription status
            $subscription->update(['status' => 'expired']);

            // Send email to user
            Mail::to($subscription->user->email)->send(new SubscriptionExpired($subscription));

            // Send email to admin
            $admin = User::where('role', 'admin')->first();
            if ($admin) {
                Mail::to($admin->email)->send(new SubscriptionExpiredAdmin($subscription));
            }

            $count++;
            $this->info("Expired subscription for user: {$subscription->user->name}");
        }

        $this->info("Total expired subscriptions processed: {$count}");
        return 0;
    }
}
