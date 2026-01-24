@extends('emails.layout')

@section('content')
    <h1 style="color: #991b1b; margin-bottom: 24px;">Subscription Expired</h1>
    
    <p style="margin-bottom: 16px;">Hello <strong>{{ $subscription->user->name }}</strong>,</p>
    
    <p style="margin-bottom: 24px;">Your <strong>{{ $subscription->plan->name }}</strong> subscription has just expired.</p>
    
    <p style="margin-bottom: 24px;">You have lost access to premium content, signals, and mentorship groups associated with this plan.</p>

@endsection
