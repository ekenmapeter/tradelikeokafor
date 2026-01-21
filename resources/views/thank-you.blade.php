<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You - Trade Like Okafor</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #01060f;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .container {
            max-width: 600px;
            width: 90%;
            background: rgba(255, 255, 255, 0.05);
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }
        .icon {
            font-size: 60px;
            color: #a9e90f;
            margin-bottom: 20px;
        }
        h1 {
            font-family: 'Montserrat', sans-serif;
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        p {
            font-size: 1.1rem;
            color: #d1d5db;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        .invoice-card {
            background: #ffffff;
            color: #111827;
            padding: 30px;
            border-radius: 15px;
            text-align: left;
            margin-bottom: 30px;
        }
        .invoice-header {
            display: flex;
            justify-content: space-between;
            border-bottom: 2px solid #f3f4f6;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }
        .invoice-title {
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.9rem;
            color: #6b7280;
        }
        .invoice-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .invoice-total {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid #f3f4f6;
            display: flex;
            justify-content: space-between;
            font-weight: 700;
            font-size: 1.2rem;
        }
        .credentials {
            background: #fef2f2;
            border: 1px solid #fee2e2;
            padding: 15px;
            border-radius: 10px;
            margin-top: 20px;
            color: #991b1b;
        }
        .btn {
            display: inline-block;
            background: #a9e90f;
            color: #01060f;
            padding: 15px 40px;
            border-radius: 10px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(169, 233, 15, 0.4);
            background: #c0f44e;
        }
        .logo {
            max-height: 60px;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
        <div class="icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <h1>Payment Received!</h1>
        <p>Your transaction was successful. We've sent a detailed receipt to <strong>{{ $user->email }}</strong>.</p>

        <div class="invoice-card">
            <div class="invoice-header">
                <span class="invoice-title">Order Receipt</span>
                <span style="font-size: 0.8rem; color: #9ca3af;">Ref: {{ $reference }}</span>
            </div>
            
            <div class="invoice-item">
                <span>Plan</span>
                <span style="font-weight: 600;">{{ $plan ? $plan->name : 'Premium Access' }}</span>
            </div>
            <div class="invoice-item">
                <span>Customer</span>
                <span style="font-weight: 600;">{{ $user->name }}</span>
            </div>
            
            <div class="invoice-total">
                <span>Total Paid</span>
                <span>${{ number_format($amount, 2) }}</span>
            </div>

            @if($tempPassword)
            <div class="credentials">
                <div style="font-weight: 700; margin-bottom: 5px;"><i class="fas fa-user-lock"></i> Account Created</div>
                <div style="font-size: 0.9rem;">Your temporary password is: <strong>{{ $tempPassword }}</strong></div>
                <div style="font-size: 0.8rem; margin-top: 5px;">You can login now to access your dashboard.</div>
            </div>
            @endif
        </div>

        <a href="{{ url('/login') }}" class="btn">Login to Dashboard</a>
        <p style="margin-top: 20px; font-size: 0.9rem; color: #9ca3af;">
            Having trouble? Contact us at support@tradelikeokafor.com
        </p>
    </div>
</body>
</html>
