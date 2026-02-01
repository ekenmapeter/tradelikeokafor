<!DOCTYPE html>
<html lang="en">
<head>
	<title>{{ $post->title }} - TRADE LIKE OKAFOR</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Open+Sans+Condensed:ital,wght@0,300;0,700;1,300&family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&family=Ubuntu+Condensed&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="{{ asset('css/animate.css') }}">
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/logo.png') }}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo.png') }}">
	<link rel="icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">
	
	<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <style>
        .post-container {
            background: #1a1a1a;
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 50px;
            border: 1px solid #333;
        }
        .post-header {
            margin-bottom: 30px;
        }
        .post-title {
            color: #fff;
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 15px;
            line-height: 1.2;
        }
        .post-meta {
            color: #a9e90f;
            font-weight: 600;
            display: flex;
            gap: 20px;
            margin-bottom: 25px;
        }
        .post-image {
            width: 100%;
            border-radius: 15px;
            margin-bottom: 35px;
            max-height: 500px;
            object-fit: cover;
        }
        .post-content {
            color: #ccc;
            line-height: 1.8;
            font-size: 1.1rem;
        }
        .post-content p {
            margin-bottom: 20px;
        }
        .sidebar-widget {
            background: #1a1a1a;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            border: 1px solid #333;
        }
        .widget-title {
            color: #fff;
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #a9e90f;
        }
        .recent-post-item {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }
        .recent-post-item img {
            width: 80px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
        }
        .recent-post-info h4 {
            color: #fff;
            font-size: 0.95rem;
            margin-bottom: 5px;
            line-height: 1.3;
        }
        .recent-post-info a {
            color: #fff;
            transition: color 0.3s ease;
        }
        .recent-post-info a:hover {
            color: #a9e90f;
        }
        .recent-post-info span {
            color: #a9e90f;
            font-size: 0.8rem;
        }
        @media (max-width: 768px) {
            .post-title {
                font-size: 1.8rem;
            }
            .post-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body style="background: #000;">
	<div class="wrap">
		<div class="container">
			<div class="row justify-content-between">
				<div class="col-12 col-md d-flex align-items-center">
					<p class="mb-0 phone"><span class="mailus">Call Support:</span> <a href="tel:+2348157841450">+2348157841450</a></p>
				</div>
                <div class="col-12 col-md d-flex justify-content-md-end">
					<div class="social-media">
						<p class="mb-0 d-flex">
							<a href="https://t.me/+xYVyIeI8RMMwZjE0" target="_blank" class="d-flex align-items-center justify-content-center">
							  <span class="fa-brands fa-telegram" aria-hidden="true"></span>
							</a>
							<a href="https://www.instagram.com/tradelikeokafor" target="_blank" class="d-flex align-items-center justify-content-center">
							  <span class="fa-brands fa-instagram" aria-hidden="true"></span>
							</a>
						  </p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
		<div class="container">
			<a class="navbar-brand" href="/"><img src="{{ asset('images/logo.png') }}" class="img-fluid" style="max-height: 3.5rem"></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="oi oi-menu"></span> Menu
			</button>

			<div class="collapse navbar-collapse" id="ftco-nav">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item"><a href="{{ route('mentorship') }}" style="background: #a9e90f!important; font-weight: 600; color: #010102!important;" class="nav-link">Mentorship</a></li>
					<li class="nav-item"><a href="{{ route('signals') }}" style="background: #02be2e; font-weight: 600; color: #ffffff!important;" class="nav-link">Trade Signals</a></li>
					<li class="nav-item"><a href="{{ route('blog.index') }}" class="nav-link">Blog</a></li>
				</ul>
			</div>
		</div>
	</nav>

	<section class="ftco-section pt-5">
		<div class="container">
			<div class="row">
				<div class="col-lg-8">
                    <div class="post-container">
                        <div class="post-header">
                            <h1 class="post-title">{{ $post->title }}</h1>
                            <div class="post-meta">
                                <span><i class="far fa-calendar-alt mr-2"></i> {{ $post->published_at->format('M d, Y') }}</span>
                                <span><i class="far fa-user mr-2"></i> Admin</span>
                            </div>
                        </div>

                        @if($post->image)
                            <img src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}" class="post-image">
                        @endif

                        <div class="post-content">
                            {!! nl2br(e($post->content)) !!}
                        </div>
                        
                        <div class="mt-5 pt-4 border-top">
                            <a href="{{ route('blog.index') }}" class="btn btn-outline-light" style="border-color: #a9e90f; color: #a9e90f;">
                                <i class="fas fa-arrow-left mr-2"></i> Back to Blog
                            </a>
                        </div>
                    </div>
				</div>

                <div class="col-lg-4">
                    <div class="sidebar-widget">
                        <h3 class="widget-title">Recent Posts</h3>
                        @foreach($recentPosts as $recent)
                        <div class="recent-post-item">
                            @if($recent->image)
                                <img src="{{ Storage::url($recent->image) }}" alt="{{ $recent->title }}">
                            @endif
                            <div class="recent-post-info">
                                <h4><a href="{{ route('blog.show', $recent->slug) }}">{{ Str::limit($recent->title, 40) }}</a></h4>
                                <span>{{ $recent->published_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="sidebar-widget">
                        <h3 class="widget-title">Join Mentorship</h3>
                        <p style="color: #ccc; font-size: 0.9rem;">Master the art of sniper entries with our professional mentorship program.</p>
                        <a href="{{ route('mentorship') }}" class="btn btn-primary btn-block" style="background: #a9e90f; color: #000; border: none; font-weight: 700;">Learn More</a>
                    </div>
                </div>
			</div>
		</div>
	</section>

	<footer id="dk-footer" class="dk-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-4">
                    <div class="dk-footer-box-info text-center text-lg-left">
                        <img src="{{ asset('images/footer_logo.png') }}" alt="footer_logo" class="img-fluid mb-4" style="width:50%;">
                        <p class="footer-info-text">Revolutionizing your trading experience with precision and clarity.</p>
                    </div>
                </div>
            </div>
        </div>
	</footer>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
</body>
</html>
