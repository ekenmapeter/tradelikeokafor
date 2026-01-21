@extends('emails.layout')

@section('content')
    <h1 style="color: #111827; margin-bottom: 24px;">Welcome, {{ $user->name }}!</h1>
    
    <p style="margin-bottom: 16px;">Thank you for joining <strong>Trade Like Okafor</strong>. We are thrilled to have you start your trading journey with us.</p>
    
    <p style="margin-bottom: 24px;">Our platform gives you access to mentorship, signals, and a community of profitable traders.</p>

    <p style="margin-top: 24px;">If you have any questions, our support team is always here to help.</p>
@endsection
