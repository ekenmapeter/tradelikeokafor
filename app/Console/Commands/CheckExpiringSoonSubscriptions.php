<?php

namespace App\Console\Commands;

use App\Models\UserSubscription;
use App\Mail\SubscriptionExpiring;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckExpiringSoonSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:check-expiring';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check subscriptions expiring within 7 days and send notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for subscriptions expiring soon...');

        // Find subscriptions expiring in the next 7 days
        $expiringSubscriptions = UserSubscription::expiringSoon()->get();

        if ($expiringSubscriptions->isEmpty()) {
            $this->info('No subscriptions expiring soon.');
            return 0;
        }

        $count = 0;
        foreach ($expiringSubscriptions as $subscription) {
            // Send email to user
            Mail::to($subscription->user->email)->send(new SubscriptionExpiring($subscription));

            $count++;
            $this->info("Notified user: {$subscription->user->name} - Expires on {$subscription->end_date->format('Y-m-d')}");
        }

        $this->info("Total expiring soon notifications sent: {$count}");
        return 0;
    }
}
