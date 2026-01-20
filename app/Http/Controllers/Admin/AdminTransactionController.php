<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['user', 'plan']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Search by user
        if ($request->filled('search')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $transactions = $query->latest()->paginate(20);

        return view('admin.transactions.index', compact('transactions'));
    }

    public function approve(Transaction $transaction)
    {
        if ($transaction->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending transactions can be approved.');
        }

        $plan = $transaction->plan;
        $user = $transaction->user;

        // Implementation like AdminUserSubscriptionController@store
        $startDate = now();
        $endDate = $startDate->copy()->addDays($plan->duration_days);

        // Cancel existing active subscriptions OR extend? 
        // Let's follow the existing pattern of cancelling old ones
        \App\Models\UserSubscription::where('user_id', $user->id)
            ->where('status', 'active')
            ->update(['status' => 'cancelled']);

        // Create new subscription
        $subscription = \App\Models\UserSubscription::create([
            'user_id' => $user->id,
            'subscription_plan_id' => $plan->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => 'active',
        ]);

        $transaction->update([
            'status' => 'completed',
            'payment_date' => now()
        ]);

        // Send Notification
        try {
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\PaymentApproved($transaction));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send approval email: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Transaction approved and subscription activated.');
    }

    public function reject(Request $request, Transaction $transaction)
    {
        if ($transaction->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending transactions can be rejected.');
        }

        $transaction->update([
            'status' => 'failed',
            'admin_notes' => $request->notes
        ]);

        // Send Notification
        try {
            \Illuminate\Support\Facades\Mail::to($transaction->user->email)->send(new \App\Mail\PaymentRejected($transaction));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send rejection email: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Transaction rejected.');
    }
}
