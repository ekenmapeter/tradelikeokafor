@extends('emails.layout')

@section('content')
    <h1 style="color: #111827; margin-bottom: 24px;">Subscription Activated!</h1>
    
    <p style="margin-bottom: 16px;">Hello <strong>{{ $subscription->user->name }}</strong>,</p>
    
    <p style="margin-bottom: 24px;">Your subscription has been successfully assigned. You now have full access to the benefits of the <strong>{{ $subscription->plan->name }}</strong>.</p>
    
    <div style="background-color: #f3f4f6; border-left: 4px solid #059669; padding: 16px; margin-bottom: 24px;">
        <h3 style="margin-top: 0; color: #059669;">Plan Details</h3>
        <table style="width: 100%;">
            <tr>
                <td style="padding: 4px 0; color: #4b5563;">Plan:</td>
                <td style="font-weight: bold; color: #111827;">{{ $subscription->plan->name }}</td>
            </tr>
            <tr>
                <td style="padding: 4px 0; color: #4b5563;">Start Date:</td>
                <td style="font-weight: bold; color: #111827;">{{ $subscription->start_date->format('M d, Y') }}</td>
            </tr>
            <tr>
                <td style="padding: 4px 0; color: #4b5563;">End Date:</td>
                <td style="font-weight: bold; color: #111827;">{{ $subscription->end_date ? $subscription->end_date->format('M d, Y') : 'Lifetime Access' }}</td>
            </tr>
        </table>
    </div>
    
  
@endsection
