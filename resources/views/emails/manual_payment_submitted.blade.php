@extends('emails.layout')

@section('content')
<div style="text-align: center; margin-bottom: 30px;">
    <h1 style="color: #4b5563; margin-bottom: 10px;">Payment Proof Received</h1>
    <p style="font-size: 18px; color: #4b5563;">Hello {{ $transaction->user->name }},</p>
</div>

<p style="margin-bottom: 24px;">We have received your manual payment proof for the <strong>{{ $transaction->plan->name }}</strong> plan. Our team is currently reviewing your submission.</p>

<div style="background-color: #f9fafb; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
    <h2 style="font-size: 16px; color: #374151; border-bottom: 1px solid #e5e7eb; padding-bottom: 10px; margin-top: 0;">Transaction Summary</h2>
    <table width="100%" style="margin-top: 10px;">
        <tr>
            <td style="color: #6b7280; padding: 5px 0;">Reference:</td>
            <td style="text-align: right; font-weight: bold; color: #111827;">{{ $transaction->reference }}</td>
        </tr>
        <tr>
            <td style="color: #6b7280; padding: 5px 0;">Plan:</td>
            <td style="text-align: right; font-weight: bold; color: #111827;">{{ $transaction->plan->name }}</td>
        </tr>
        <tr>
            <td style="color: #6b7280; padding: 5px 0;">Amount:</td>
            <td style="text-align: right; font-weight: bold; color: #111827;">${{ number_format($transaction->amount, 2) }}</td>
        </tr>
        <tr>
            <td style="color: #6b7280; padding: 5px 0;">Date:</td>
            <td style="text-align: right; font-weight: bold; color: #111827;">{{ $transaction->created_at->format('M d, Y') }}</td>
        </tr>
    </table>
</div>

<h3 style="color: #374151; font-size: 18px; margin-bottom: 12px;">What's next?</h3>
<p style="margin-bottom: 24px;">We will verify the payment within 24-48 hours. Once approved, your subscription will be activated automatically, and you will receive another email confirmation.</p>

<div style="text-align: center;">
    <a href="{{ route('dashboard') }}" class="btn">Track Transaction</a>
</div>
@endsection
