@extends('emails.layout')

@section('content')
<div style="text-align: center; margin-bottom: 30px;">
    <h1 style="color: #059669; margin-bottom: 10px;">Order Received! ✅</h1>
    <p style="font-size: 18px; color: #4b5563;">Hello {{ $order->customer_name }},</p>
</div>

<p style="margin-bottom: 24px;">Thank you for your ebook purchase! We have received your order and payment proof. Our team will verify your payment and process your order shortly.</p>

<div style="background-color: #f9fafb; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
    <h2 style="font-size: 16px; color: #374151; border-bottom: 1px solid #e5e7eb; padding-bottom: 10px; margin-top: 0;">Order Details</h2>
    <table width="100%" style="margin-top: 10px;">
        <tr>
            <td style="color: #6b7280; padding: 5px 0;">Order Number:</td>
            <td style="text-align: right; font-weight: bold; color: #111827;">{{ $order->order_number }}</td>
        </tr>
        <tr>
            <td style="color: #6b7280; padding: 5px 0;">Ebook:</td>
            <td style="text-align: right; font-weight: bold; color: #111827;">{{ $order->ebook->title }}</td>
        </tr>
        <tr>
            <td style="color: #6b7280; padding: 5px 0;">Amount:</td>
            <td style="text-align: right; font-weight: bold; color: #111827;">${{ number_format($order->amount, 2) }}</td>
        </tr>
        <tr>
            <td style="color: #6b7280; padding: 5px 0;">Payment Method:</td>
            <td style="text-align: right; font-weight: bold; color: #111827;">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</td>
        </tr>
        <tr>
            <td style="color: #6b7280; padding: 5px 0;">Status:</td>
            <td style="text-align: right; font-weight: bold; color: #f59e0b;">⏳ Pending Review</td>
        </tr>
    </table>
</div>

<div style="background-color: #fffbeb; padding: 16px; border-radius: 8px; border-left: 4px solid #f59e0b; margin-bottom: 24px;">
    <p style="margin: 0; color: #92400e; font-size: 14px;"><strong>What's Next?</strong></p>
    <p style="margin: 8px 0 0; color: #92400e; font-size: 14px;">Our admin team will review your payment proof. Once verified, your ebook PDF will be delivered to this email address. This usually takes a few hours.</p>
</div>

<p style="margin-top: 24px;">Thank you for choosing <strong>Trade Like Okafor</strong>!</p>
@endsection
