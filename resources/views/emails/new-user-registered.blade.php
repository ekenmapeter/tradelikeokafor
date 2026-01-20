@extends('emails.layout')

@section('content')
    <h1 style="color: #111827; margin-bottom: 24px;">New User Registration</h1>
    
    <p style="margin-bottom: 16px;">Hello Admin,</p>
    <p style="margin-bottom: 16px;">A new user has just registered on the platform. Here are their details:</p>
    
    <table style="width: 100%; background-color: #f3f4f6; border-radius: 8px; padding: 16px; margin-bottom: 24px;">
        <tr>
            <td style="padding: 8px 0; font-weight: bold; width: 80px;">Name:</td>
            <td>{{ $user->name }}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; font-weight: bold;">Email:</td>
            <td>{{ $user->email }}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; font-weight: bold;">Date:</td>
            <td>{{ $user->created_at->format('M d, Y h:i A') }}</td>
        </tr>
    </table>
    
    <div style="text-align: center;">
        <a href="{{ route('admin.users.index') }}" class="btn">View Users</a>
    </div>
@endsection
