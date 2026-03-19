@extends('emails.layout')

@section('content')
<div style="text-align: center; margin-bottom: 30px;">
    <h1 style="color: #059669; margin-bottom: 10px;">Your Ebook is Ready! 🎉📖</h1>
    <p style="font-size: 18px; color: #4b5563;">Hello {{ $order->customer_name }},</p>
</div>

<p style="margin-bottom: 24px;">Great news! Your payment has been verified and approved. Your ebook <strong>"{{ $order->ebook->title }}"</strong> is attached to this email as a PDF.</p>

<div style="background-color: #ecfdf5; padding: 20px; border-radius: 8px; border-left: 4px solid #059669; margin-bottom: 30px;">
    <p style="margin: 0; color: #065f46; font-size: 14px;"><strong>✅ Payment Approved</strong></p>
    <p style="margin: 8px 0 0; color: #065f46; font-size: 14px;">Your ebook PDF is attached to this email. Download it and start learning today!</p>
</div>

<div style="background-color: #f9fafb; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
    <h2 style="font-size: 16px; color: #374151; border-bottom: 1px solid #e5e7eb; padding-bottom: 10px; margin-top: 0;">Order Summary</h2>
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
            <td style="color: #6b7280; padding: 5px 0;">Amount Paid:</td>
            <td style="text-align: right; font-weight: bold; color: #111827;">${{ number_format($order->amount, 2) }}</td>
        </tr>
        <tr>
            <td style="color: #6b7280; padding: 5px 0;">Status:</td>
            <td style="text-align: right; font-weight: bold; color: #059669;">✅ Approved</td>
        </tr>
    </table>
</div>

<p style="margin-top: 24px;">If you have any issues downloading the attachment, please reply to this email or contact our support team.</p>

<p style="margin-top: 24px;">Happy reading! 📚<br><strong>Trade Like Okafor Team</strong></p>
@endsection
