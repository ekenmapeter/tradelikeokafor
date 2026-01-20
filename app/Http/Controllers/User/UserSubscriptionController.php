<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class UserSubscriptionController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $activeSubscription = $user->activeSubscription;
        $subscriptionHistory = $user->subscriptions()->latest()->paginate(10);
        $availablePlans = SubscriptionPlan::active()->get();

        return view('user.subscriptions', compact('activeSubscription', 'subscriptionHistory', 'availablePlans'));
    }

    public function manualPayment(SubscriptionPlan $plan)
    {
        $settings = \App\Models\Setting::all()->pluck('value', 'key');
        return view('user.manual_payment', compact('plan', 'settings'));
    }

    public function submitManualPayment(Request $request, SubscriptionPlan $plan)
    {
        $request->validate([
            'proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = auth()->user();
        
        // Store proof
        $proofPath = $request->file('proof')->store('proofs', 'public');

        // Create transaction
        $transaction = \App\Models\Transaction::create([
            'user_id' => $user->id,
            'subscription_plan_id' => $plan->id,
            'amount' => $plan->price,
            'reference' => 'MANUAL-' . strtoupper(uniqid()),
            'proof' => $proofPath,
            'status' => 'pending',
            'payment_date' => now(),
        ]);

        // Send Notification to Admin and User
        try {
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\ManualPaymentSubmitted($transaction));
            
            // Send to admin - finding an admin user
            $admin = \App\Models\User::where('role', 'admin')->first();
            if ($admin) {
                \Illuminate\Support\Facades\Mail::to($admin->email)->send(new \App\Mail\Admin\NewManualPaymentNotification($transaction));
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send manual payment emails: ' . $e->getMessage());
        }
        
        return redirect()->route('user.transactions')->with('success', 'Payment proof uploaded successfully. We will review it shortly.');
    }
}
