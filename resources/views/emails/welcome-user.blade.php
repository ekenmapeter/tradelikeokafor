@extends('emails.layout')

@section('content')
    <h1 style="color: #111827; margin-bottom: 24px;">Welcome, {{ $user->name }}!</h1>
    
    <p style="margin-bottom: 16px;">Thank you for joining <strong>Trade Like Okafor</strong>. We are thrilled to have you start your trading journey with us.</p>
    
    @if(isset($password))
        <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 16px; margin: 24px 0;">
            <p style="margin-top: 0; color: #166534; font-weight: bold;">Your Account Credentials</p>
            <p style="margin: 8px 0;"><strong>Email:</strong> {{ $user->email }}</p>
            <p style="margin: 8px 0;"><strong>Password:</strong> <span style="font-family: monospace; background: #fff; padding: 2px 6px; border-radius: 4px; border: 1px solid #ddd;">{{ $password }}</span></p>
            <p style="margin-bottom: 0; font-size: 13px; color: #166534;">*Please change your password immediately after logging in.</p>
        </div>
    @endif

    <p style="margin-bottom: 24px;">Our platform gives you access to mentorship, signals, and a community of profitable traders.</p>

    <div style="text-align: center;">
        <a href="{{ route('login') }}" class="btn">Login to Dashboard</a>
    </div>

    <p style="margin-top: 24px;">If you have any questions, our support team is always here to help.</p>
@endsection
