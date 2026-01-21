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
    /**
     * Handle the callback when a user is redirected back from Paystack.
     */
    public function handleCallback(Request $request)
    {
        $reference = $request->query('reference');

        if (!$reference) {
            return redirect('/')->with('error', 'No reference found');
        }

        // Verify transaction with Paystack to be extra safe
        $secretKey = config('services.paystack.secret_key');
        
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $secretKey,
            'Content-Type' => 'application/json',
        ])->get("https://api.paystack.co/transaction/verify/" . $reference);

        if (!$response->successful() || $response['data']['status'] !== 'success') {
            return redirect('/')->with('error', 'Payment verification failed');
        }

        $paymentData = $response['data'];
        $result = $this->processPayment($paymentData);

        return view('thank-you', [
            'user' => $result['user'],
            'amount' => $result['amount'],
            'plan' => $result['plan'],
            'reference' => $paymentData['reference'],
            'tempPassword' => $result['tempPassword']
        ]);
    }

    /**
     * Handle the asynchronous webhook from Paystack.
     */
    public function handleWebhook(Request $request)
    {
        // Retrieve the request's body and parse it as JSON
        $input = $request->getContent();
        $secretKey = config('services.paystack.secret_key');

        // Validate the signature
        if ($request->header('x-paystack-signature') !== hash_hmac('sha512', $input, $secretKey)) {
            Log::error('Paystack Webhook Signature Mismatch');
            return response()->json(['message' => 'Invalid signature'], 401);
        }

        $event = json_decode($input, true);

        // Check if the event is charge.success
        if (isset($event['event']) && $event['event'] === 'charge.success') {
            $paymentData = $event['data'];
            
            // Log webhook receipt
            Log::info('Paystack Webhook received for reference: ' . $paymentData['reference']);
            
            $this->processPayment($paymentData);
            
            return response()->json(['status' => 'success'], 200);
        }

        return response()->json(['status' => 'ignored'], 200);
    }

    /**
     * Shared logic for processing a successful payment.
     */
    protected function processPayment($paymentData)
    {
        $reference = $paymentData['reference'];
        $email = $paymentData['customer']['email'];
        $amount = $paymentData['amount'] / 100; // Convert kobo to standard currency
        $metadata = $paymentData['metadata'] ?? [];

        // Check if transaction already processed to avoid duplicates
        $existingTransaction = Transaction::where('reference', $reference)->where('status', 'approved')->first();
        if ($existingTransaction) {
            return [
                'user' => $existingTransaction->user,
                'amount' => $amount,
                'plan' => $existingTransaction->plan,
                'tempPassword' => null
            ];
        }

        // Find or create user
        $user = User::where('email', $email)->first();
        $tempPassword = null;

        if (!$user) {
            $tempPassword = Str::random(10);
            $user = User::create([
                'name' => ($paymentData['customer']['first_name'] ?? 'Guest') . ' ' . ($paymentData['customer']['last_name'] ?? 'User'),
                'email' => $email,
                'password' => Hash::make($tempPassword),
                'role' => 'user',
                'status' => 'active',
            ]);
        }

        // Identify the plan
        $plan = SubscriptionPlan::where('price_ngn', $amount)
            ->orWhere('price', $amount)
            ->first();

        if (!$plan && isset($metadata['plan_name'])) {
            $plan = SubscriptionPlan::where('name', $metadata['plan_name'])->first();
        }

        // Create transaction record
        $transaction = Transaction::updateOrCreate(
            ['reference' => $reference],
            [
                'user_id' => $user->id,
                'subscription_plan_id' => $plan ? $plan->id : null,
                'amount' => $amount,
                'status' => 'approved',
                'payment_date' => now(),
            ]
        );

        // Assign subscription
        if ($plan) {
            UserSubscription::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'subscription_plan_id' => $plan->id,
                ],
                [
                    'start_date' => now(),
                    'end_date' => null, // Lifetime
                    'status' => 'active',
                ]
            );
        }

        // Send emails
        try {
            Mail::to($user->email)->send(new PaymentSuccessReceipt($user, $amount, $plan, $tempPassword));
            
            $adminEmail = env('ADMIN_EMAIL', 'support@tradelikeokafor.com');
            Mail::to($adminEmail)->send(new NewPaymentNotification($user, $amount, $plan, $reference));
        } catch (\Exception $e) {
            Log::error('Mail Error in Paystack process: ' . $e->getMessage());
        }

        return [
            'user' => $user,
            'amount' => $amount,
            'plan' => $plan,
            'tempPassword' => $tempPassword
        ];
    }
}
