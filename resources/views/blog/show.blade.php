<!DOCTYPE html>
<html lang="en">
<head>
	<title>{{ $post->title }} - TRADE LIKE OKAFOR</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Open+Sans+Condensed:ital,wght@0,300;0,700;1,300&family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&family=Ubuntu+Condensed&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

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
            margin-bottom: 25px;
        }
        .post-content h2, .post-content h3, .post-content h4 {
            color: #fff;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            margin-top: 40px;
            margin-bottom: 20px;
        }
        .post-content h2 { font-size: 1.8rem; }
        .post-content h3 { font-size: 1.5rem; }
        .post-content ul, .post-content ol {
            margin-bottom: 25px;
            padding-left: 20px;
        }
        .post-content li {
            margin-bottom: 10px;
        }
        .post-content blockquote {
            border-left: 4px solid #a9e90f;
            padding: 20px 30px;
            background: rgba(169, 233, 15, 0.05);
            font-style: italic;
            margin: 30px 0;
            color: #eee;
        }
        .post-content a {
            color: #a9e90f;
            text-decoration: underline;
        }
        .post-content a:hover {
            color: #fff;
        }
        
        .post-content img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin: 20px 0;
        }
        .post-content .image {
            margin: 20px 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .post-content .image-style-side {
            float: right;
            max-width: 50%;
            margin-left: 20px;
        }
        .post-content .image-style-block-align-left {
            float: left;
            margin-right: 20px;
        }
        .post-content .image > figcaption {
            display: block;
            caption-side: bottom;
            word-break: break-word;
            color: #888;
            font-size: 0.8em;
            padding-top: 0.5em;
            text-align: center;
        }
        .post-content table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
            color: #fff;
            background: #222;
        }
        .post-content table th, .post-content table td {
            border: 1px solid #444;
            padding: 12px;
            text-align: left;
        }
        .post-content table th {
            background: #333;
            color: #a9e90f;
        }
        .post-content .media {
            margin: 30px 0;
            position: relative;
            padding-bottom: 56.25%; /* 16:9 aspect ratio */
            height: 0;
            overflow: hidden;
        }
        .post-content .media iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
            border-radius: 10px;
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
			<div class="row">
				<div class="col-lg-8">
                    <div class="post-container">
                        <div class="post-header">
                            <h1 class="post-title">{{ $post->title }}</h1>
                            <div class="post-meta">
                                <span><i class="far fa-calendar-alt mr-2"></i> {{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }}</span>
                                <span><i class="far fa-user mr-2"></i> Admin</span>
                            </div>
                        </div>

                        @if($post->image)
                            <img src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}" class="post-image">
                        @endif

                        <div class="post-content">
                            {!! $post->content !!}
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
                                <span>{{ $recent->published_at ? $recent->published_at->format('M d, Y') : $recent->created_at->format('M d, Y') }}</span>
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
									<li>
									  <a href="https://www.instagram.com/tradelikeokafor" target="_blank">
										<i class="fa-brands fa-instagram"></i>
									  </a>
									</li>
									<li>
									  <a href="https://youtube.com/@tradelikeokafor" target="_blank">
										<i class="fa-brands fa-youtube"></i>
									  </a>
									</li>
									<li>
									  <a href="https://t.me/+xYVyIeI8RMMwZjE0" target="_blank">
										<i class="fa-brands fa-telegram"></i>
									  </a>
									</li>
								  </ul>
	                        </div>
	                        <!-- End Social link -->
	                    </div>
	                </div>
	                <!-- End Col -->
	                <div class="col-md-12 col-lg-8">
	                    <div class="row footer_m">
	                        <div class="col-md-6">
	                            <div style="margin-left: 50px; margin-top: 10px;">
	                                <div class="contact-icon">
	                                </div>
	                                <!-- End contact Icon -->
	                                <div>
	                                    <h3 style="color: #fff; font-weight: 900;">Nigeria</h3>
	                                    <h6 style="margin-top: -7px">Lagos Offices</h6><br><br>
	                                </div>
	                                <!-- End Contact Info -->
	                            </div>
	                            <!-- End Contact Us -->
	                        </div>
	                        <!-- End Col -->
	                        <div class="col-md-6">
	                            <div style="margin-left: 50px; margin-top: 10px;">
	                                <div class="contact-icon">
	                                </div>
	                                <!-- End contact Icon -->
	                                <div>
	                                    <h3 style="color: #fff; font-weight: 600; line-height: 1.25;">
											+2348157841450 <br>
	                                     </h3>
	                                    <h6 style="margin-top: -7px">Give us a call</h6><br><br>
	                                </div>
	                                <!-- End Contact Info -->
	                            </div>
	                            <!-- End Contact Us -->
	                        </div>
	                        <!-- End Col -->
	                    </div>
	                    <!-- End Contact Row -->
	                    <div class="row">
	                        <div class="col-md-12 col-lg-6">
	                            <div class="footer-widget footer-left-widget">
	                                <div class="section-heading">
	                                    <h3>Useful Links</h3><!--
	                                    <span class="animate-border border-black"></span>-->
	                                </div>
	                                <ul>
	                                    <!--<li>
	                                        <a href="./Masterclass" target="_blank">Masterclass</a>
	                                    </li> -->
	                                    <li>
	                                        <a href="{{ route('mentorship') }}" target="_blank">Mentorship</a>
	                                    </li>
	                                    <li>
	                                        <a href="{{ route('signals') }}" target="_blank">Trade Signals</a>
	                                    </li>
	                                </ul>
	                                <ul>
	                                    <!-- <li>
	                                        <a href="#resources" target="_blank">Resources</a>
	                                    </li> -->
	                                   
	                                    <li>
	                                        <a href="https://www.vantagemarkets.com/forex-trading/forex-trading-account/?affid=NzQzMDU=" target="_blank">Recommended Broker</a>
	                                    </li>
	                                </ul>
	                            </div>
	                            <!-- End Footer Widget -->
	                        </div>
	                        <!-- End col -->
	                        <div class="col-md-12 col-lg-6">
	                            <div class="footer-widget" style="padding-left: 50px;">
	                                <div class="section-heading">
	                                    <h3>Subscribe</h3><!--
	                                    <span class="animate-border border-black"></span> -->
	                                </div>
	                                <span>
	                                Never miss an update from us, Subscribe here:<br></span>
	
	                                <form action="" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate="">
	                                    <div class="form-row">
	                                        <div class="col dk-footer-form">
	                                            <input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL" class="form-control" placeholder="Email Address">
									    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_a939b9a617962057d7d97d766_2360e68684" tabindex="-1" value=""></div>
									        <div class="optionalParent">
									            <div class="clear foot">
									                <input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button" style="visibility: hidden;">
									            </div>
									        </div>
	                                        </div>
	                                    </div>
	                                </form>
	                                <!-- End form -->
	                            </div>
	                            <!-- End footer widget -->
	                        </div>
	                        <!-- End Col -->
	                    </div>
	                    <!-- End Row -->
	                </div>
	                <!-- End Col -->
	            </div>
	        </div>
	        <!-- Back to top -->
	        <div id="back-to-top" class="back-to-top">
	            <a href="#"><button class="btn btn-dark" title="Back to Top" style="display: block;">
	                <i class="fa fa-angle-up"></i>
	            </button></a>
	        </div>
	        <div class="copyright">
	            <div class="container">
				<div class="row">
	                <div class="col-md-12 col-sm-12 col-lg-12"><b style="font-size: 1.35em; line-height: 0.85; margin-top: 5px; margin-bottom: 25px; color: #fff; letter-spacing: -1px;">Ikeja<ygreen> Trading Floor</ygreen></b><br>
	                	<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.428995431039!2d3.3660043594126736!3d6.593482772320989!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x103b93c5f605cd7f%3A0x4ce61da54bf0d476!2stradelikeokafor!5e0!3m2!1sen!2sus!4v1758553350769!5m2!1sen!2sus" width="100%" height="135" style="border: 3px; solid #EAEEF1FF; border-radius: 8px;" allowfullscreen="" loading="lazy"></iframe><br>
							<p style="font-size: 1.15em; line-height: 1; margin-left: 10px; margin-top: 5px; margin-bottom: 25px; color: #fff; letter-spacing: -1px;">
								 <b><ygreen>Location:</ygreen></b> <br>Block 1 plot 8 <b><ygreen>Memunat ayodeji crescent,</ygreen></b><br> Etal Ave, Ikeja Lagos NG, Oregun, Ikeja 100271, Lagos, Nigeria.</p>
	                </div>
				</div>
				</div>
				
	            <div class="container">
					<div class="row">
						<div class="col-md-12 text-center">
							<p><h6 style="font-size: 0.75em;">
								 <b>Disclaimer: </b>This site contains strictly Educational materials for Leverage Trading. No form of Solicitation or other guarantee is intended.<br> Trading and/or investing in Leveraged Products comes with a substaintial amount of risk and you may loose part or all of your investments. Be Advised.</h6>
						</div>
					</div>
				</div>
	                <!-- End Row -->
	        </div>
	        
	        <div class="copyright">
	            <div class="container">
				<div class="row">
					<div class="col-md-12 text-center">
						<p><h6 style="font-size: 0.75em;">
							 <b>TRADE LIKE OKAFOR</b> | Copyright &copy;<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script>document.write(new Date().getFullYear());</script> All rights reserved <br> Developed by <a href="https://t.me/ekenmapeter" target="_blank"> Shevootech Online</a></h6>
					</div>
				</div>
				</div>
	                <!-- End Row -->
	            </div>
	            <!-- End Copyright Container -->
	</footer>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery-migrate-3.0.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.easing.1.3.js') }}"></script>
    <script src="{{ asset('js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('js/jquery.stellar.min.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('js/jquery.animateNumber.min.js') }}"></script>
    <script src="{{ asset('js/scrollax.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
