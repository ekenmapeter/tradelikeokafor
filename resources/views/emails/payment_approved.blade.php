@extends('emails.layout')

@section('content')
<div style="text-align: center; margin-bottom: 30px;">
    <h1 style="color: #059669; margin-bottom: 10px;">Payment Approved! 🎉</h1>
    <p style="font-size: 18px; color: #4b5563;">Hello {{ $transaction->user->name }},</p>
</div>

<p style="margin-bottom: 24px;">Great news! Your manual payment for the <strong>{{ $transaction->plan->name }}</strong> plan has been successfully verified and approved.</p>

<div style="background-color: #f9fafb; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
    <h2 style="font-size: 16px; color: #374151; border-bottom: 1px solid #e5e7eb; padding-bottom: 10px; margin-top: 0;">Subscription Details</h2>
    <table width="100%" style="margin-top: 10px;">
        <tr>
            <td style="color: #6b7280; padding: 5px 0;">Plan:</td>
            <td style="text-align: right; font-weight: bold; color: #111827;">{{ $transaction->plan->name }}</td>
        </tr>
        <tr>
            <td style="color: #6b7280; padding: 5px 0;">Price:</td>
            <td style="text-align: right; font-weight: bold; color: #111827;">${{ number_format($transaction->amount, 2) }}</td>
        </tr>
        <tr>
            <td style="color: #6b7280; padding: 5px 0;">Start Date:</td>
            <td style="text-align: right; font-weight: bold; color: #111827;">{{ now()->format('M d, Y') }}</td>
        </tr>
        <tr>
            <td style="color: #6b7280; padding: 5px 0;">Reference:</td>
            <td style="text-align: right; font-weight: bold; color: #111827;">{{ $transaction->reference }}</td>
        </tr>
    </table>
</div>

<div style="text-align: center;">
    <a href="{{ route('dashboard') }}" class="btn">Go to Dashboard</a>
</div>

<p style="margin-top: 24px;">Thank you for choosing <strong>Trade Like Okafor</strong>. We're excited to have you on board!</p>
@endsection
