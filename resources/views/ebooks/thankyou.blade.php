<!DOCTYPE html>
<html lang="en">
<head>
	<title>Order Confirmed - TRADE LIKE OKAFOR</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">
	<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        .thankyou-section {
            min-height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0a0a0a 0%, #1a1a2e 50%, #000 100%);
            padding: 60px 0;
        }
        .thankyou-card {
            background: #1a1a1a;
            border-radius: 20px;
            padding: 50px 40px;
            max-width: 600px;
            width: 100%;
            text-align: center;
            border: 1px solid #2a2a2a;
            position: relative;
            overflow: hidden;
        }
        .thankyou-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #a9e90f, #02be2e, #a9e90f);
        }
        .success-icon {
            width: 80px;
            height: 80px;
            background: rgba(169, 233, 15, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            animation: pulse 2s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        .success-icon i {
            font-size: 2.5rem;
            color: #a9e90f;
        }
        .thankyou-card h1 {
            color: #fff;
            font-size: 1.8rem;
            font-weight: 800;
            margin-bottom: 10px;
        }
        .thankyou-card .subtitle {
            color: #a9e90f;
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 25px;
        }
        .order-summary {
            background: #111;
            border-radius: 12px;
            padding: 20px;
            margin: 25px 0;
            text-align: left;
        }
        .order-summary .row-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #222;
        }
        .order-summary .row-item:last-child {
            border-bottom: none;
        }
        .order-summary .row-item .label {
            color: #888;
            font-size: 0.9rem;
        }
        .order-summary .row-item .value {
            color: #fff;
            font-weight: 700;
            font-size: 0.9rem;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
            background: rgba(245, 158, 11, 0.15);
            color: #f59e0b;
        }
        .info-text {
            color: #888;
            font-size: 0.9rem;
            line-height: 1.7;
            margin-top: 20px;
        }
        .btn-back {
            display: inline-block;
            padding: 12px 30px;
            background: #a9e90f;
            color: #000;
            font-weight: 700;
            border-radius: 8px;
            text-decoration: none;
            margin-top: 25px;
            transition: all 0.3s;
        }
        .btn-back:hover {
            background: #fff;
            color: #000;
            text-decoration: none;
        }
    </style>
</head>
<body style="background: #000;">
    <section class="thankyou-section">
        <div class="container">
            <div class="d-flex justify-content-center">
                <div class="thankyou-card">
                    <a href="/"><img src="{{ asset('images/logo.png') }}" alt="Logo" style="max-height: 50px; margin-bottom: 30px;"></a>
                    
                    <div class="success-icon">
                        <i class="fas fa-check"></i>
                    </div>

                    <h1>Order Submitted!</h1>
                    <p class="subtitle">Your payment is being reviewed</p>

                    <div class="order-summary">
                        <div class="row-item">
                            <span class="label">Order Number</span>
                            <span class="value">{{ $order->order_number }}</span>
                        </div>
                        <div class="row-item">
                            <span class="label">Ebook</span>
                            <span class="value">{{ $order->ebook->title }}</span>
                        </div>
                        <div class="row-item">
                            <span class="label">Amount</span>
                            <span class="value">${{ number_format($order->amount, 2) }}</span>
                        </div>
                        <div class="row-item">
                            <span class="label">Payment Method</span>
                            <span class="value">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span>
                        </div>
                        <div class="row-item">
                            <span class="label">Status</span>
                            <span class="status-badge">⏳ Pending Review</span>
                        </div>
                    </div>

                    <p class="info-text">
                        <i class="fas fa-envelope" style="color: #a9e90f;"></i> 
                        A confirmation email has been sent to <strong style="color: #fff;">{{ $order->customer_email }}</strong>.<br>
                        Once your payment is verified, the ebook PDF will be delivered to your email.
                    </p>

                    <a href="{{ route('ebooks.index') }}" class="btn-back">
                        <i class="fas fa-arrow-left mr-2"></i> Browse More Ebooks
                    </a>
                </div>
            </div>
        </div>
    </section>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
</body>
</html>
