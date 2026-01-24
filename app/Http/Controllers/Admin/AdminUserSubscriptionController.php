<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use App\Models\Transaction;
use App\Mail\SubscriptionAssigned;
use App\Mail\WelcomeUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminUserSubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $query = UserSubscription::with(['user', 'plan']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $subscriptions = $query->latest()->paginate(15);

        return view('admin.subscriptions.index', compact('subscriptions'));
    }

    public function create()
    {
        $users = User::where('role', 'user')->where('status', 'active')->get();
        $plans = SubscriptionPlan::active()->get();

        return view('admin.subscriptions.create', compact('users', 'plans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'subscription_plan_id' => 'required|exists:subscription_plans,id',
            'start_date' => 'required|date',
        ]);

        $plan = SubscriptionPlan::findOrFail($validated['subscription_plan_id']);
        $startDate = \Carbon\Carbon::parse($validated['start_date']);
        
        // Calculate end date based on plan duration
        $endDate = null; 
        if ($plan->duration_days > 0) {
            $endDate = (clone $startDate)->addDays($plan->duration_days);
        }

        // Cancel any existing active subscriptions for this user
        UserSubscription::where('user_id', $validated['user_id'])
            ->where('status', 'active')
            ->update(['status' => 'cancelled']);

        // Create new subscription
        $subscription = UserSubscription::create([
            'user_id' => $validated['user_id'],
            'subscription_plan_id' => $validated['subscription_plan_id'],
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => 'active',
        ]);

        // Create transaction record
        Transaction::create([
            'user_id' => $validated['user_id'],
            'subscription_plan_id' => $validated['subscription_plan_id'],
            'amount' => $plan->price,
            'reference' => 'ADMIN-' . strtoupper(Str::random(10)),
            'status' => 'completed',
            'payment_date' => now(),
        ]);

        // Send email notifications to user
        $user = User::findOrFail($validated['user_id']);
        
        // Send Welcome Email
        Mail::to($user->email)->send(new WelcomeUser($user));
        
        // Send Subscription Assigned Email
        Mail::to($user->email)->send(new SubscriptionAssigned($subscription));

        return redirect()->route('admin.subscriptions.index')
            ->with('success', 'Subscription assigned successfully. Emails sent to user.');
    }

    public function cancel(UserSubscription $subscription)
    {
        $subscription->update(['status' => 'cancelled']);

        return redirect()->back()
            ->with('success', 'Subscription cancelled successfully.');
    }
}
