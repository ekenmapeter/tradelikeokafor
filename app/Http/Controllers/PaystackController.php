<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use App\Mail\PaymentSuccessReceipt;
use App\Mail\Admin\NewPaymentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaystackController extends Controller
{
    public function handleCallback(Request $request)
    {
        $reference = $request->query('reference');

        if (!$reference) {
            return redirect('/')->with('error', 'No reference found');
        }

        // Verify transaction with Paystack
        $secretKey = config('services.paystack.secret_key') ?? env('PAYSTACK_SECRET_KEY');
        
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $secretKey,
            'Content-Type' => 'application/json',
        ])->get("https://api.paystack.co/transaction/verify/" . $reference);

        if (!$response->successful() || $response['data']['status'] !== 'success') {
            return redirect('/')->with('error', 'Payment verification failed');
        }

        $paymentData = $response['data'];
        $email = $paymentData['customer']['email'];
        $amount = $paymentData['amount'] / 100; // Paystack sends amount in kobo
        $metadata = $paymentData['metadata'];
        
        // Find or create user
        $user = User::where('email', $email)->first();
        $isNewUser = false;
        $tempPassword = null;

        if (!$user) {
            $isNewUser = true;
            $tempPassword = Str::random(10);
            $user = User::create([
                'name' => $paymentData['customer']['first_name'] . ' ' . $paymentData['customer']['last_name'],
                'email' => $email,
                'password' => Hash::make($tempPassword),
                'role' => 'user',
                'status' => 'active',
            ]);
        }

        // Try to identify the plan
        // You can use amount or custom metadata if you set it up in Paystack
        // For now, let's try to match by price_ngn or price
        $plan = SubscriptionPlan::where('price_ngn', $amount)
            ->orWhere('price', $amount)
            ->first();

        // If not found by exact amount, maybe try to match by name in metadata if available
        if (!$plan && isset($metadata['plan_name'])) {
            $plan = SubscriptionPlan::where('name', $metadata['plan_name'])->first();
        }

        // Create transaction record
        Transaction::updateOrCreate(
            ['reference' => $reference],
            [
                'user_id' => $user->id,
                'subscription_plan_id' => $plan ? $plan->id : null,
                'amount' => $amount,
                'status' => 'approved',
                'payment_date' => now(),
            ]
        );

        // Active subscription
        if ($plan) {
            UserSubscription::create([
                'user_id' => $user->id,
                'subscription_plan_id' => $plan->id,
                'start_date' => now(),
                'end_date' => null, // Lifetime access as per previous session
                'status' => 'active',
            ]);
        }

        // Send emails
        try {
            Mail::to($user->email)->send(new PaymentSuccessReceipt($user, $amount, $plan, $tempPassword));
            
            // Notify admin
            $adminEmail = env('ADMIN_EMAIL', 'support@tradelikeokafor.com');
            Mail::to($adminEmail)->send(new NewPaymentNotification($user, $amount, $plan, $reference));
        } catch (\Exception $e) {
            Log::error('Mail Error: ' . $e->getMessage());
        }

        return view('thank-you', [
            'user' => $user,
            'amount' => $amount,
            'plan' => $plan,
            'reference' => $reference,
            'tempPassword' => $tempPassword
        ]);
    }
}
