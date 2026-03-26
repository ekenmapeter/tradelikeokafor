<!DOCTYPE html>
<html lang="en">
<head>
	<title>{{ $ebook->title }} - TRADE LIKE OKAFOR Ebooks</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="{{ Str::limit($ebook->short_description, 160) }}">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&family=Open+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="{{ asset('css/animate.css') }}">
	<link rel="icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">
	<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <style>
        .ftco-navbar-light {
            top: 40px !important;
        }

        .purchase-section {
            padding: 160px 0 80px;
            background: #000;
            min-height: 60vh;
        }
        .ebook-detail-card {
            background: #1a1a1a;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #2a2a2a;
        }
        .ebook-detail-img {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }
        .ebook-detail-img-placeholder {
            width: 100%;
            height: 400px;
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #a9e90f;
        }
        .ebook-detail-body {
            padding: 30px;
        }
        .ebook-detail-title {
            color: #fff;
            font-size: 1.8rem;
            font-weight: 800;
            margin-bottom: 15px;
        }
        .ebook-detail-desc {
            color: #bbb;
            font-size: 1rem;
            line-height: 1.8;
            margin-bottom: 20px;
        }
        .ebook-detail-price {
            font-size: 2.5rem;
            font-weight: 800;
            color: #a9e90f;
            margin-bottom: 10px;
        }

        .purchase-form-card {
            background: #1a1a1a;
            border-radius: 16px;
            padding: 30px;
            border: 1px solid #2a2a2a;
        }
        .purchase-form-card h3 {
            color: #fff;
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #a9e90f;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            color: #ccc;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 8px;
        }
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px 16px;
            background: #111;
            border: 1px solid #333;
            border-radius: 8px;
            color: #fff;
            font-size: 1rem;
            transition: border 0.3s;
        }
        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #a9e90f;
        }
        .form-group input[type="file"] {
            padding: 10px;
        }

        .payment-options {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }
        .payment-option {
            flex: 1;
            padding: 16px;
            background: #111;
            border: 2px solid #333;
            border-radius: 12px;
            cursor: pointer;
            text-align: center;
            transition: all 0.3s;
        }
        .payment-option:hover {
            border-color: #a9e90f;
        }
        .payment-option.active {
            border-color: #a9e90f;
            background: rgba(169, 233, 15, 0.05);
        }
        .payment-option input[type="radio"] {
            display: none;
        }
        .payment-option i {
            font-size: 2rem;
            margin-bottom: 8px;
            display: block;
        }
        .payment-option span {
            color: #ccc;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .payment-details {
            background: #111;
            border: 1px solid #333;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            display: none;
        }
        .payment-details.show {
            display: block;
        }
        .payment-details h4 {
            color: #a9e90f;
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 15px;
        }
        .payment-details p {
            color: #bbb;
            font-size: 0.9rem;
            margin-bottom: 8px;
        }
        .payment-details .detail-value {
            color: #fff;
            font-weight: 700;
        }

        .btn-submit-purchase {
            width: 100%;
            padding: 14px;
            background: #a9e90f;
            color: #000;
            font-weight: 800;
            font-size: 1.1rem;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-submit-purchase:hover {
            background: #fff;
            transform: scale(1.02);
        }
        .btn-submit-purchase:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .error-text {
            color: #ef4444;
            font-size: 0.85rem;
            margin-top: 5px;
        }
        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid #ef4444;
            color: #ef4444;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .back-link {
            color: #a9e90f;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 30px;
        }
        .back-link:hover {
            color: #fff;
            text-decoration: none;
        }

        .ftco-section { padding: 0; }
    </style>
</head>
<body style="background: #000;">
	<div class="wrap">
		<div class="container">
			<div class="row justify-content-between">
				<div class="col-12 col-md d-flex align-items-center">
					<p class="mb-0 phone"><span class="mailus">Call Support:</span> <a href="tel:+2348157841450">+2348157841450</a>  or <span class="mailus">email us:</span> <a href="email:support@tradelikeokafor.com"><span>support@tradelikeokafor.com</span></a></p>
				</div>
				<div class="col-12 col-md d-flex justify-content-md-end">
					<div class="social-media">
						<p class="mb-0 d-flex">
							<a href="https://t.me/+xYVyIeI8RMMwZjE0" target="_blank" class="d-flex align-items-center justify-content-center"><span class="fa-brands fa-telegram"></span></a>
							<a href="https://www.instagram.com/tradelikeokafor" target="_blank" class="d-flex align-items-center justify-content-center"><span class="fa-brands fa-instagram"></span></a>
							<a href="https://youtube.com/@tradelikeokafor" target="_blank" class="d-flex align-items-center justify-content-center"><span class="fa-brands fa-youtube"></span></a>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
		<div class="container">
			<a class="navbar-brand" href="/"><img src="{{ asset('images/logo.png') }}" class="img-fluid" style="max-height: 3.5rem"></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav">
				<span class="oi oi-menu"></span> Menu
			</button>
			<div class="collapse navbar-collapse" id="ftco-nav">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item"><a href="{{ route('mentorship') }}" style="background: #02be2e!important; font-weight: 600; color: #ffffff!important;" class="nav-link">Mentorship</a></li>
					<li class="nav-item"><a href="{{ route('signals') }}" style="background: #02be2e!important; font-weight: 600; color: #ffffff!important;" class="nav-link">Trade Signals</a></li>
					<li class="nav-item"><a href="{{ route('blog.index') }}" style="background: #02be2e!important; font-weight: 600; color: #ffffff!important;" class="nav-link">Blog</a></li>
					<li class="nav-item active"><a href="{{ route('ebooks.index') }}" style="background: #02be2e!important; font-weight: 600; color: #ffffff!important;" class="nav-link">📚 Ebooks</a></li>
					<li class="nav-item"><a href="https://t.me/+xYVyIeI8RMMwZjE0" style="background: #02be2e!important; color: #ffffff!important; font-weight: 600;" class="nav-link">Free Telegram Channel</a></li>
					<li class="nav-item cta"><a href="https://www.vantagemarkets.com/forex-trading/forex-trading-account/?affid=NzQzMDU=" class="nav-link">Recommended broker</a></li>
				</ul>
			</div>
		</div>
	</nav>

    <section class="purchase-section">
        <div class="container">
            <a href="{{ route('ebooks.index') }}" class="back-link"><i class="fas fa-arrow-left"></i> Back to Ebooks</a>

            @if($errors->any())
                <div class="alert-danger">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                {{-- Ebook Details --}}
                <div class="col-lg-5 mb-4">
                    <div class="ebook-detail-card">
                        @if($ebook->cover_image)
                            <img src="{{ Storage::url($ebook->cover_image) }}" alt="{{ $ebook->title }}" class="ebook-detail-img">
                        @else
                            <div class="ebook-detail-img-placeholder">
                                <i class="fas fa-book-open fa-5x"></i>
                            </div>
                        @endif
                        <div class="ebook-detail-body">
                            <h1 class="ebook-detail-title">{{ $ebook->title }}</h1>
                            <p class="ebook-detail-desc">{{ $ebook->short_description }}</p>
                            <div class="ebook-detail-price">
                                ${{ number_format($ebook->price, 2) }}
                                @if($ebook->price_naira)
                                    <span style="font-size: 0.6em; color: #888; margin: 0 10px;">/</span>
                                    ₦{{ number_format($ebook->price_naira, 0) }}
                                @endif
                            </div>
                            <p style="color: #777; font-size: 0.85rem;"><i class="fas fa-file-pdf mr-1"></i> PDF Format — Instant delivery after payment verification</p>
                        </div>
                    </div>
                </div>

                {{-- Purchase Form --}}
                <div class="col-lg-7">
                    <div class="purchase-form-card">
                        <h3><i class="fas fa-shopping-bag mr-2"></i> Complete Your Purchase</h3>

                        <form action="{{ route('ebooks.purchase', $ebook->slug) }}" method="POST" enctype="multipart/form-data" id="purchaseForm">
                            @csrf

                            <div class="form-group">
                                <label for="customer_name"><i class="fas fa-user mr-1"></i> Full Name *</label>
                                <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name') }}" required placeholder="Enter your full name">
                                @error('customer_name') <span class="error-text">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label for="customer_email"><i class="fas fa-envelope mr-1"></i> Email Address *</label>
                                <input type="email" name="customer_email" id="customer_email" value="{{ old('customer_email') }}" required placeholder="your@email.com — ebook will be sent here">
                                @error('customer_email') <span class="error-text">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label for="customer_phone"><i class="fas fa-phone mr-1"></i> Phone Number (Optional)</label>
                                <input type="text" name="customer_phone" id="customer_phone" value="{{ old('customer_phone') }}" placeholder="+234...">
                            </div>

                            <div class="form-group">
                                <label><i class="fas fa-credit-card mr-1"></i> Payment Method *</label>
                                <div class="payment-options">
                                    <label class="payment-option {{ old('payment_method') === 'paypal' ? 'active' : '' }}" id="paypalOption">
                                        <input type="radio" name="payment_method" value="paypal" {{ old('payment_method') === 'paypal' ? 'checked' : '' }}>
                                        <i class="fab fa-paypal" style="color: #0070ba;"></i>
                                        <span>PayPal</span>
                                    </label>
                                    <label class="payment-option {{ old('payment_method') === 'bank_transfer' ? 'active' : '' }}" id="bankOption">
                                        <input type="radio" name="payment_method" value="bank_transfer" {{ old('payment_method') === 'bank_transfer' ? 'checked' : '' }}>
                                        <i class="fas fa-university" style="color: #a9e90f;"></i>
                                        <span>Bank Transfer</span>
                                    </label>
                                </div>
                                @error('payment_method') <span class="error-text">{{ $message }}</span> @enderror
                            </div>

                            {{-- PayPal Details --}}
                            <div class="payment-details" id="paypalDetails">
                                <h4><i class="fab fa-paypal mr-1"></i> PayPal Payment Instructions</h4>
                                <p>Send <span class="detail-value">${{ number_format($ebook->price, 2) }}</span> to the PayPal email below:</p>
                                <p style="background: #1a1a1a; padding: 12px; border-radius: 8px; text-align: center;">
                                    <span class="detail-value" style="font-size: 1.1rem;">{{ $settings['paypal_email'] ?? 'support@tradelikeokafor.com' }}</span>
                                </p>
                                <p style="color: #f59e0b; font-size: 0.85rem; margin-top: 10px;"><i class="fas fa-info-circle mr-1"></i> Use "Friends & Family" option. After payment, take a screenshot and upload it below.</p>
                            </div>

                            {{-- Bank Transfer Details --}}
                            <div class="payment-details" id="bankDetails">
                                <h4><i class="fas fa-university mr-1"></i> Bank Transfer Details</h4>
                                <p>Transfer <span class="detail-value">@if($ebook->price_naira) ₦{{ number_format($ebook->price_naira, 0) }} @else ${{ number_format($ebook->price, 2) }} @endif</span> to the account below:</p>
                                <div style="background: #1a1a1a; padding: 16px; border-radius: 8px; margin-top: 10px;">
                                    <p style="margin-bottom: 8px;">Bank: <span class="detail-value">{{ $settings['bank_name'] ?? 'N/A' }}</span></p>
                                    <p style="margin-bottom: 8px;">Account Name: <span class="detail-value">{{ $settings['account_name'] ?? 'N/A' }}</span></p>
                                    <p style="margin-bottom: 0;">Account Number: <span class="detail-value">{{ $settings['account_number'] ?? 'N/A' }}</span></p>
                                </div>
                                <p style="color: #f59e0b; font-size: 0.85rem; margin-top: 10px;"><i class="fas fa-info-circle mr-1"></i> After payment, take a screenshot of the transfer receipt and upload it below.</p>
                            </div>

                            <div class="form-group">
                                <label for="payment_proof"><i class="fas fa-cloud-upload-alt mr-1"></i> Upload Payment Proof *</label>
                                <input type="file" name="payment_proof" id="payment_proof" accept="image/*" required>
                                <p style="color: #777; font-size: 0.8rem; margin-top: 5px;">Accepted: JPG, PNG, GIF. Max 5MB.</p>
                                @error('payment_proof') <span class="error-text">{{ $message }}</span> @enderror
                            </div>

                            <button type="submit" class="btn-submit-purchase" id="submitBtn">
                                <i class="fas fa-lock mr-2"></i> Submit Payment — <span id="displayPrice">${{ number_format($ebook->price, 2) }} @if($ebook->price_naira) / ₦{{ number_format($ebook->price_naira, 0) }} @endif</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer id="dk-footer" class="dk-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-4">
                    <div class="dk-footer-box-info">
                        <a href="/" class="footer-logo">
                            <img src="{{ asset('images/footer_logo.png') }}" alt="footer_logo" class="img-fluid" style="display:block; margin: 0 auto; width:50%;">
                        </a>
                        <p class="footer-info-text">Our strategy helps you find the best chances to make money in the market.</p>
                    </div>
                </div>
                <div class="col-md-12 col-lg-8">
                    <div class="row footer_m">
                        <div class="col-md-6"><div style="margin-left: 50px; margin-top: 10px;"><div><h3 style="color: #fff; font-weight: 900;">Nigeria</h3><h6 style="margin-top: -7px">Lagos Offices</h6></div></div></div>
                        <div class="col-md-6"><div style="margin-left: 50px; margin-top: 10px;"><div><h3 style="color: #fff; font-weight: 600;">+2348157841450</h3><h6 style="margin-top: -7px">Give us a call</h6></div></div></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright">
            <div class="container">
                <div class="row"><div class="col-md-12 text-center"><h6 style="font-size: 0.75em;"><b>TRADE LIKE OKAFOR</b> | Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved</h6></div></div>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery-migrate-3.0.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paypalOption = document.getElementById('paypalOption');
            const bankOption = document.getElementById('bankOption');
            const paypalDetails = document.getElementById('paypalDetails');
            const bankDetails = document.getElementById('bankDetails');

            function updatePaymentView() {
                const selected = document.querySelector('input[name="payment_method"]:checked');
                
                paypalOption.classList.remove('active');
                bankOption.classList.remove('active');
                paypalDetails.classList.remove('show');
                bankDetails.classList.remove('show');

                if (selected) {
                    if (selected.value === 'paypal') {
                        paypalOption.classList.add('active');
                        paypalDetails.classList.add('show');
                    } else {
                        bankOption.classList.add('active');
                        bankDetails.classList.add('show');
                    }
                }
            }

            paypalOption.addEventListener('click', updatePaymentView);
            bankOption.addEventListener('click', updatePaymentView);

            // Init on page load
            updatePaymentView();

            // Prevent double submit
            document.getElementById('purchaseForm').addEventListener('submit', function() {
                const btn = document.getElementById('submitBtn');
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';
            });
        });
    </script>
</body>
</html>
