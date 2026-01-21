@extends('emails.layout')

@section('content')
<div style="text-align: center; margin-bottom: 30px;">
    <h1 style="color: #059669; margin-bottom: 10px;">Payment Successful!</h1>
    <p style="font-size: 18px; color: #4b5563;">Thank you for your payment, {{ $user->name }}.</p>
</div>

<div style="background-color: #f9fafb; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
    <h2 style="font-size: 16px; color: #374151; border-bottom: 1px solid #e5e7eb; padding-bottom: 10px; margin-top: 0;">Order Summary</h2>
    <table width="100%" style="margin-top: 10px;">
        <tr>
            <td style="color: #6b7280; padding: 5px 0;">Plan:</td>
            <td style="text-align: right; font-weight: bold; color: #111827;">{{ $plan ? $plan->name : 'Custom Payment' }}</td>
        </tr>
        <tr>
            <td style="color: #6b7280; padding: 5px 0;">Amount:</td>
            <td style="text-align: right; font-weight: bold; color: #111827;">{{ number_format($amount, 2) }}</td>
        </tr>
        @if($tempPassword)
        <tr>
            <td colspan="2" style="padding-top: 20px; border-top: 1px dashed #e5e7eb;">
                <p style="margin-top: 0; color: #ef4444; font-weight: bold;">Account Created</p>
                <p style="margin: 5px 0; font-size: 14px;">An account has been created for you to access our premium resources.</p>
                <p style="margin: 5px 0; font-size: 14px;"><strong>Login Email:</strong> {{ $user->email }}</p>
                <p style="margin: 5px 0; font-size: 14px;"><strong>Temporary Password:</strong> {{ $tempPassword }}</p>
                <p style="margin: 5px 0; font-size: 12px; color: #6b7280;">Please change your password after logging in.</p>
            </td>
        </tr>
        @endif
    </table>
</div>

<div style="text-align: center;">
    <p style="margin-bottom: 20px; color: #4b5563;">You can now access your dashboard to view your signals and mentorship materials.</p>
    <a href="{{ url('/login') }}" class="btn">Login to Dashboard</a>
</div>
@endsection
