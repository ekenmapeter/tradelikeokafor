@extends('emails.layout')

@section('content')
<div style="text-align: center; margin-bottom: 30px;">
    <h1 style="color: #059669; margin-bottom: 10px;">New Ebook Order! 📚</h1>
    <p style="font-size: 18px; color: #4b5563;">A new ebook purchase has been submitted.</p>
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
        <tr>
            <td style="color: #6b7280; padding: 5px 0;">Payment Method:</td>
            <td style="text-align: right; font-weight: bold; color: #111827;">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</td>
        </tr>
    </table>
</div>

<div style="background-color: #f9fafb; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
    <h2 style="font-size: 16px; color: #374151; border-bottom: 1px solid #e5e7eb; padding-bottom: 10px; margin-top: 0;">Customer Info</h2>
    <table width="100%" style="margin-top: 10px;">
        <tr>
            <td style="color: #6b7280; padding: 5px 0;">Name:</td>
            <td style="text-align: right; font-weight: bold; color: #111827;">{{ $order->customer_name }}</td>
        </tr>
        <tr>
            <td style="color: #6b7280; padding: 5px 0;">Email:</td>
            <td style="text-align: right; font-weight: bold; color: #111827;">{{ $order->customer_email }}</td>
        </tr>
        @if($order->customer_phone)
        <tr>
            <td style="color: #6b7280; padding: 5px 0;">Phone:</td>
            <td style="text-align: right; font-weight: bold; color: #111827;">{{ $order->customer_phone }}</td>
        </tr>
        @endif
    </table>
</div>

<div style="text-align: center; margin-top: 24px;">
    <a href="{{ url('/admin/ebook-orders') }}" class="btn" style="display: inline-block; padding: 12px 32px; background-color: #059669; color: #ffffff; border-radius: 6px; font-weight: bold; text-decoration: none;">Review Order →</a>
</div>
@endsection
