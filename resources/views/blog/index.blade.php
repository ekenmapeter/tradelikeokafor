<!DOCTYPE html>
<html lang="en">
<head>
	<title>Blog - TRADE LIKE OKAFOR :: Running digits up!</title>
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
        .blog-card {
            background: #1a1a1a;
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 30px;
            transition: transform 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            border: 1px solid #333;
        }
        .blog-card:hover {
            transform: translateY(-5px);
            border-color: #a9e90f;
        }
        .blog-card img {
            width: 100%;
            height: 200px;
            object-cover: cover;
        }
        .blog-content {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        .blog-title {
            color: #fff;
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 10px;
            text-transform: capitalize;
        }
        .blog-excerpt {
            color: #ccc;
            font-size: 0.9rem;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .blog-meta {
            color: #a9e90f;
            font-size: 0.8rem;
            margin-bottom: 15px;
            font-weight: 600;
        }
        .btn-read-more {
            background: #a9e90f;
            color: #000;
            font-weight: 700;
            padding: 8px 20px;
            border-radius: 5px;
            text-align: center;
            display: inline-block;
            transition: background 0.3s ease;
            margin-top: auto;
        }
        .btn-read-more:hover {
            background: #fff;
            color: #000;
        }
        .pagination-container {
            margin-top: 40px;
        }
        .pagination-container .pagination {
            justify-content: center;
        }
    </style>
</head>
<body style="background: #000;">
	<div class="wrap">
		<div class="container">
			<div class="row justify-content-between">
				<div class="col-12 col-md d-flex align-items-center">
					<p class="mb-0 phone"><span class="mailus">Call Support:</span> <a href="tel:+2348157841450">+2348157841450</a>  or <span class="mailus">email us:</span> <a href="email:support@tradelikeokafor.com"><span class="">support@tradelikeokafor.com</span></a></p>
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
							<a href="https://youtube.com/@tradelikeokafor" target="_blank" class="d-flex align-items-center justify-content-center">
							  <span class="fa-brands fa-youtube" aria-hidden="true"></span>
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
					<li class="nav-item active"><a href="{{ route('blog.index') }}" class="nav-link">Blog</a></li>
					<li class="nav-item cta"><a href="https://www.vantagemarkets.com/forex-trading/forex-trading-account/?affid=NzQzMDU=" class="nav-link">Recommended Broker</a></li>
				</ul>
			</div>
		</div>
	</nav>
	
	<section class="ftco-section pt-5">
		<div class="container">
			<div class="row justify-content-center mb-5">
				<div class="col-md-7 heading-section text-center ftco-animate">
					<h2 class="mb-4" style="color: #fff; font-weight: 800;">Our Blog</h2>
					<p style="color: #ccc;">Insights, updates, and trading tips from the TRADE LIKE OKAFOR team.</p>
				</div>
			</div>
			
			<div class="row">
				@forelse($posts as $post)
				<div class="col-md-4 mb-4 ftco-animate">
                    <div class="blog-card">
                        @if($post->image)
                            <img src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}">
                        @else
                            <div style="height: 200px; background: #333; display: flex; align-items: center; justify-content: center; color: #666;">
                                <i class="fas fa-image fa-3x"></i>
                            </div>
                        @endif
                        <div class="blog-content">
                            <div class="blog-meta">
                                <i class="far fa-calendar-alt mr-2"></i> {{ $post->published_at->format('M d, Y') }}
                            </div>
                            <h3 class="blog-title">{{ $post->title }}</h3>
                            <p class="blog-excerpt">{{ Str::limit($post->short_description, 120) }}</p>
                            <a href="{{ route('blog.show', $post->slug) }}" class="btn-read-more">Read More</a>
                        </div>
                    </div>
				</div>
                @empty
                <div class="col-12 text-center py-5">
                    <p style="color: #ccc;">No blog posts available yet. Check back soon!</p>
                </div>
				@endforelse
			</div>

            @if($posts->hasPages())
			<div class="row pagination-container">
				<div class="col text-center">
					{{ $posts->links() }}
				</div>
			</div>
            @endif
		</div>
	</section>

	<footer id="dk-footer" class="dk-footer">
		<!-- Same footer as home.blade.php -->
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-4">
                    <div class="dk-footer-box-info">
                        <a href="/" class="footer-logo">
                            <img src="{{ asset('images/footer_logo.png') }}" alt="footer_logo" class="img-fluid" style="display:block; margin: 0 auto; width:50%;">
                        </a>
                        <p class="footer-info-text">
                            Our strategy helps you find the best chances to make money in the market, while keeping the risky parts small so you can keep more of the profit.
                        </p>
                        <div class="footer-social-link">
                            <h3>Follow us</h3>
                            <ul>
                                <li><a href="https://www.instagram.com/tradelikeokafor" target="_blank"><i class="fa-brands fa-instagram"></i></a></li>
                                <li><a href="https://youtube.com/@tradelikeokafor" target="_blank"><i class="fa-brands fa-youtube"></i></a></li>
                                <li><a href="https://t.me/+xYVyIeI8RMMwZjE0" target="_blank"><i class="fa-brands fa-telegram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-8">
                    <div class="row footer_m">
                        <div class="col-md-6">
                            <div style="margin-left: 50px; margin-top: 10px;">
                                <h3 style="color: #fff; font-weight: 900;">Nigeria</h3>
                                <h6 style="margin-top: -7px">Lagos Offices</h6>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div style="margin-left: 50px; margin-top: 10px;">
                                <h3 style="color: #fff; font-weight: 600;">+2348157841450</h3>
                                <h6 style="margin-top: -7px">Give us a call</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <p><h6 style="font-size: 0.75em;">
                             <b>Trade Like Okafor</b> | Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved</h6></p>
                    </div>
                </div>
            </div>
        </div>
	</footer>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
