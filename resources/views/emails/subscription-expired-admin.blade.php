@extends('emails.layout')

@section('content')
    <h1 style="color: #1f2937; margin-bottom: 24px;">User Subscription Expired</h1>
    
    <p style="margin-bottom: 16px;">Hello Admin,</p>
    <p style="margin-bottom: 16px;">A user's subscription has just expired automatically.</p>
    
    <table style="width: 100%; background-color: #f3f4f6; border-radius: 8px; padding: 16px; margin-bottom: 24px;">
        <tr>
            <td style="padding: 8px 0; font-weight: bold; width: 100px;">User:</td>
            <td>{{ $subscription->user->name }}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; font-weight: bold;">Email:</td>
            <td>{{ $subscription->user->email }}</td>
        </tr>
         <tr>
            <td style="padding: 8px 0; font-weight: bold;">Plan:</td>
            <td>{{ $subscription->plan->name }}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; font-weight: bold;">Expired On:</td>
            <td>{{ $subscription->end_date->format('M d, Y') }}</td>
        </tr>
    </table>
    
    <div style="text-align: center;">
        <a href="{{ route('admin.subscriptions.index') }}" class="btn">Manage Subscriptions</a>
    </div>
@endsection
