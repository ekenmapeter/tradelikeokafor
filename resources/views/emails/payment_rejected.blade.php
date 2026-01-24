@extends('emails.layout')

@section('content')
<div style="text-align: center; margin-bottom: 30px;">
    <h1 style="color: #ef4444; margin-bottom: 10px;">Payment Declined</h1>
    <p style="font-size: 18px; color: #4b5563;">Hello {{ $transaction->user->name }},</p>
</div>

<p style="margin-bottom: 24px;">We were unable to verify your manual payment proof for the <strong>{{ $transaction->plan->name }}</strong> plan, and your request has been declined.</p>

<div style="background-color: #fef2f2; border: 1px solid #fee2e2; border-radius: 8px; padding: 20px; margin-bottom: 30px;">
    <h2 style="font-size: 16px; color: #991b1b; border-bottom: 1px solid #fecaca; padding-bottom: 10px; margin-top: 0;">Reason for Rejection</h2>
    <p style="color: #991b1b; margin-top: 10px;">
        {{ $transaction->admin_notes ?? 'The uploaded proof was insufficient or invalid. Please ensure the screenshot clearly shows the transaction details and reference.' }}
    </p>
</div>

<h3 style="color: #374151; font-size: 18px; margin-bottom: 12px;">What can you do?</h3>
<p style="margin-bottom: 24px;">You can re-upload a valid proof of payment through your transaction history or try a different payment method.</p>

<div style="background-color: #f9fafb; padding: 15px; border-radius: 8px; margin-bottom: 24px; font-size: 14px;">
    <strong>Transaction Info:</strong><br>
    Reference: {{ $transaction->reference }}<br>
    Plan: {{ $transaction->plan->name }}
</div>


<p style="margin-top: 24px;">If you believe this is a mistake or need further assistance, please contact our support team.</p>
@endsection
