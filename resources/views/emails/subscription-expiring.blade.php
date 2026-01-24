@extends('emails.layout')

@section('content')
    <h1 style="color: #b45309; margin-bottom: 24px;">Subscription Expiring Soon</h1>
    
    <p style="margin-bottom: 16px;">Hello <strong>{{ $subscription->user->name }}</strong>,</p>
    
    <p style="margin-bottom: 24px;">This is a friendly reminder that your <strong>{{ $subscription->plan->name }}</strong> subscription is set to expire on <strong style="color: #b45309;">{{ $subscription->end_date ? $subscription->end_date->format('M d, Y') : 'Lifetime Access' }}</strong>.</p>
    
    <div style="background-color: #fffbeb; border: 1px solid #fcd34d; border-radius: 8px; padding: 16px; margin-bottom: 24px;">
        <p style="margin: 0; color: #92400e;">Don't lose your access to premium signals and mentorship. Renew now to keep your momentum going!</p>
    </div>
    
@endsection
