@extends('emails.layout')

@section('content')
<div style="text-align: center; margin-bottom: 30px;">
    <h1 style="color: #ef4444; margin-bottom: 10px;">Order Update</h1>
    <p style="font-size: 18px; color: #4b5563;">Hello {{ $order->customer_name }},</p>
</div>

<p style="margin-bottom: 24px;">We regret to inform you that your order for <strong>"{{ $order->ebook->title }}"</strong> could not be processed at this time.</p>

<div style="background-color: #fef2f2; padding: 20px; border-radius: 8px; border-left: 4px solid #ef4444; margin-bottom: 30px;">
    <p style="margin: 0; color: #991b1b; font-size: 14px;"><strong>❌ Order Declined</strong></p>
    @if($order->admin_note)
        <p style="margin: 8px 0 0; color: #991b1b; font-size: 14px;">Reason: {{ $order->admin_note }}</p>
    @else
        <p style="margin: 8px 0 0; color: #991b1b; font-size: 14px;">Your payment proof could not be verified. Please ensure you submit a clear and valid payment proof.</p>
    @endif
</div>

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
    </table>
</div>

<p style="margin-top: 24px;">If you believe this is a mistake, please contact our support team and we'll be happy to assist you.</p>

<div style="text-align: center; margin-top: 24px;">
    <a href="{{ url('/ebooks') }}" class="btn" style="display: inline-block; padding: 12px 32px; background-color: #059669; color: #ffffff; border-radius: 6px; font-weight: bold; text-decoration: none;">Try Again →</a>
</div>
@endsection
