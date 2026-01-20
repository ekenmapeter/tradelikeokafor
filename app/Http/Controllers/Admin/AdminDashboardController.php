<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserSubscription;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'active_users' => User::where('role', 'user')->where('status', 'active')->count(),
            'suspended_users' => User::where('role', 'user')->where('status', 'suspended')->count(),
            'total_subscriptions' => UserSubscription::count(),
            'active_subscriptions' => UserSubscription::active()->count(),
            'expired_subscriptions' => UserSubscription::where('status', 'expired')->count(),
            'total_revenue' => Transaction::where('status', 'completed')->sum('amount'),
            'monthly_revenue' => Transaction::where('status', 'completed')
                ->whereMonth('payment_date', now()->month)
                ->sum('amount'),
            'new_users_today' => User::where('role', 'user')->whereDate('created_at', now()->today())->count(),
            'subscriptions_by_plan' => \App\Models\SubscriptionPlan::withCount(['subscriptions' => function($query) {
                $query->where('status', 'active');
            }])->get(),
        ];

        $recent_users = User::where('role', 'user')
            ->latest()
            ->take(5)
            ->get();

        $recent_transactions = Transaction::with(['user', 'plan'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_users', 'recent_transactions'));
    }
}
