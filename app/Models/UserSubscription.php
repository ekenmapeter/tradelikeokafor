<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class UserSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subscription_plan_id',
        'start_date',
        'end_date',
        'status',
        'payment_proof',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the user that owns the subscription.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the subscription plan.
     */
    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id');
    }

    /**
     * Check if subscription is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active' && ($this->end_date === null || $this->end_date >= now());
    }

    /**
     * Check if subscription is expired.
     */
    public function isExpired(): bool
    {
        if ($this->end_date === null) {
            return $this->status === 'expired';
        }
        return $this->end_date < now() || $this->status === 'expired';
    }

    /**
     * Get days remaining in subscription.
     */
    public function daysRemaining(): int|string
    {
        if ($this->end_date === null) {
            return 'Lifetime';
        }
        if ($this->isExpired()) {
            return 0;
        }
        return now()->diffInDays($this->end_date, false);
    }

    /**
     * Check if subscription is expiring soon (within 7 days).
     */
    public function isExpiringSoon(): bool
    {
        if ($this->end_date === null) {
            return false;
        }
        $daysRemaining = $this->daysRemaining();
        return is_numeric($daysRemaining) && $daysRemaining > 0 && $daysRemaining <= 7;
    }

    /**
     * Scope a query to only include active subscriptions.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('end_date')
                  ->orWhere('end_date', '>=', now());
            });
    }

    /**
     * Scope a query to only include expired subscriptions.
     */
    public function scopeExpired($query)
    {
        return $query->where(function ($q) {
            $q->where(function ($sq) {
                $sq->whereNotNull('end_date')
                  ->where('end_date', '<', now());
            })->orWhere('status', 'expired');
        });
    }

    /**
     * Scope a query to only include subscriptions expiring soon.
     */
    public function scopeExpiringSoon($query)
    {
        return $query->where('status', 'active')
            ->whereBetween('end_date', [now(), now()->addDays(7)]);
    }
}
