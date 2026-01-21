<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Google tag (gtag.js) -->
 
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/logo.png') }}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo.png') }}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo.png') }}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo.png') }}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo.png') }}">
	<link rel="icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">
	<link rel="manifest" href="{{ asset('site.webmanifest') }}">


  <style> body {background-image: url('{{ asset('images/banner-home-group.png') }}'); background-repeat: no-repeat; background-attachment: fixed; background-size: cover;} </style>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Open+Sans+Condensed:ital,wght@0,300;0,700;1,300&family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&family=Ubuntu+Condensed&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

  <title>General Mentorship Payment Options | TRADE LIKE OKAFOR</title>
  <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-M1GGY22G2V"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-M1GGY22G2V');
</script>
</head>
<body style="background-color: rgb(1 6 15 / 90%); background-blend-mode: overlay;">

  <div class="container">
    <div class="row">
        <div class="col-md-5">
          <div class="card" style="border: none; padding-bottom: 30px; background-color: #fff0;">
            <div class="card-header mt-3" style="padding-top: 30px; padding-bottom: 20px; border-bottom-right-radius: 12px; border-bottom-left-radius: 12px; margin-bottom: 20px; background-color: #eceae6;">
                <h3 class="card-title" style="font-size: 1.25em;"><a class="navbar-brand" href="/"><img id="company-logo-img" src="{{ asset('images/logo.png') }}" alt="Company Logo" class="img-fluid" style="height: 40px;"></a>Mentorship | TRADE LIKE OKAFOR <span style="color: #7e8e8f;"> </span></h3>
            </div>
            <div class="card-body" style="padding: 20px; margin: 5px; border-radius: 8px; line-height: 0.85; background: #eceae6">
                <form id="paymentForm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-left" viewbox="0 0 16 16"><path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"></path>
              </svg><a class="btn btn-success" href="{{ route('mentorship') }}" role="button" style="font-size: 13px;">Back</a><hr>
                  <div class="form-group">
                    <h1 style="    font-size: 0.65em; color: #acacac; margin-left: 0.35em; margin-bottom: -8px;">
                    <label for="fee">USD - INTERNATIONAL PAYMENT</label>
                    </h1>
                    <h4 style="font-size: 2em;margin-bottom: -8px;">
                    <label for="fee">$250</label>
                    </h4>
                    <label>
                    <h6 style="margin-top: -1px; color: #82b68d; font-size: 14px;">+ Charges Inclusive</h6><hr></label>
                    <h6 style="font-size: 1.2em;margin-bottom: -5px;">
                        <label for="fee">General Class Mentorship</label>
                    </h6><br>
                    
                    <br>

                    <label>
                      <h6 style="font-size: 13px; margin-top: -8px">
                      Physical Training - Choose a Trading Floor
                      <br><b>Intensive One Month Training</b>
                      <br>Beginner To Masterclass Course
                      <br><b>Prop Firm Challenge Training</b>
                      <br><b>Earn Masterclass Certificate</b><br>
                      <br><span style="color: #7e8e8f;">Payment would be processed by <a target="_blank" href="https://www.korahq.com/company"> Kora</a></span></h6>
                    </label>

                    <hr>

                  <div class="form-group" style="font-size: 14px; font-weight: bold; line-height: 1.2em;">
                    
                    <label for="location" required="">Choose a Trading Floor:</label><br>

                    &nbsp;<input type="radio" id="ikeja" name="location" value="./payment/Ikeja">
                    <label for="ikeja">Ikeja</label>&nbsp;&nbsp;  <br><br>
                    <label><h6 style="font-size: 13px; margin-top: -8px">Please Note:<br><b>Kindly choose a Trading Floor close to your location</b><br><span style="color: #7e8e8f;">If you can't make it to any of these locations, consider the  <a target="_blank" href="{{ route('mentorship-payment-online') }}"> Online General Mentorship Option</a></span></h6></label><br> 
                  </div>


                  </div>
                </form>
            <script src="ajax/libs/jquery/1.8.3/jquery.min.js"></script>

            <script>
            $('input[type="radio"]').on('click', function() {
                 window.location = $(this).val();
            });
            </script>
            </div>
          </div>
        </div>
        <div class="sticky-top">
          <div class="alert alert-success" style="background-color: rgba(7, 5, 28, 0.79); top: 20px; margin-left: 20px; position: sticky;">
              <button type="button" style="color: #fff;" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <span class="glyphicon glyphicon-ok"></span>

            <br>
            <h5 style="margin-left: 15px;"><b style="line-height: 1; color: #957a04; font-weight: 700; letter-spacing: -1px;">Recommended Broker
            <br>
            <a href="https://my.assexmarkets.com/auth/register?partner_code=6381684" target="_blank">Register a Trading Account</a></b></h5>
            <span style="line-height: 0.75; color: #d8d8d8; letter-spacing: -1px;">
              <a href="https://my.assexmarkets.com/auth/register?partner_code=6381684" target="_blank">
              <img src="img/assexmarkets.jpg" alt="Recommended Broker" class="img-fluid" style="height: 286px; width: auto; margin-top: 8px; margin-bottom: 6px;"></a>
            </span>
            <br>
          </div>
        </div>
    </div>
  </div>

  <footer style="background-color: #0a0a0a; color: #fff;">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
              <span><h6 style="font-size: 0.75em;"><br>
								 <b>Disclaimer: </b>This site contains strictly Educational materials for Leverage Trading. No form of Solicitation or other guarantee is intended.<br> Trading and/or investing in Leveraged Products comes with a substaintial amount of risk and you may loose part or all of your investments. Be Advised.</h6></span>
            </div>
        </div>
    </div>
    <div class="copyright">
        <div class="container">
          <div class="row">
            <div class="col-md-12 text-center">
              <p><h6 style="font-size: 0.75em;">
                 <b>TRADE LIKE OKAFOR</b> | Copyright &copy; 2020 - <script>document.write(new Date().getFullYear());</script> All rights reserved <br> Developed by <a href="https://t.me/ekenmapeter" target="_blank"> Shevootech Online</a></h6>
            </div>
          </div>
        </div>
    </div>
  </footer>

<script src="js/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="js/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<script src="js/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="js/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    
 
    
</body>
</html>