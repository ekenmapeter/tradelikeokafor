@extends('emails.layout')

@section('content')
<div style="text-align: center; margin-bottom: 30px;">
    <h1 style="color: #059669; margin-bottom: 10px;">New Payment Received</h1>
    <p style="font-size: 18px; color: #4b5563;">A new payment has been processed via Paystack.</p>
</div>

<div style="background-color: #f9fafb; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
    <h2 style="font-size: 16px; color: #374151; border-bottom: 1px solid #e5e7eb; padding-bottom: 10px; margin-top: 0;">Transaction Details</h2>
    <table width="100%" style="margin-top: 10px;">
        <tr>
            <td style="color: #6b7280; padding: 5px 0;">Customer Name:</td>
            <td style="text-align: right; font-weight: bold; color: #111827;">{{ $user->name }}</td>
        </tr>
        <tr>
            <td style="color: #6b7280; padding: 5px 0;">Customer Email:</td>
            <td style="text-align: right; font-weight: bold; color: #111827;">{{ $user->email }}</td>
        </tr>
        <tr>
            <td style="color: #6b7280; padding: 5px 0;">Plan:</td>
            <td style="text-align: right; font-weight: bold; color: #111827;">{{ $plan ? $plan->name : 'Custom Payment' }}</td>
        </tr>
        <tr>
            <td style="color: #6b7280; padding: 5px 0;">Amount Paid:</td>
            <td style="text-align: right; font-weight: bold; color: #111827;">{{ number_format($amount, 2) }}</td>
        </tr>
        <tr>
            <td style="color: #6b7280; padding: 5px 0;">Reference:</td>
            <td style="text-align: right; font-weight: bold; color: #111827;">{{ $reference }}</td>
        </tr>
    </table>
</div>

<div style="text-align: center;">
    <p style="margin-bottom: 20px; color: #4b5563;">Log in to the admin panel to manage this user and their subscription.</p>
    <a href="{{ url('/admin/dashboard') }}" class="btn">Go to Admin Panel</a>
</div>
@endsection
