<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - TRADE LIKE OKAFOR</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;800&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body {
            background-color: #000;
            color: #fff;
            font-family: 'Open Sans', sans-serif;
            margin: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .container {
            max-width: 600px;
            padding: 20px;
        }
        .error-code {
            font-family: 'Montserrat', sans-serif;
            font-size: 8rem;
            font-weight: 800;
            color: #a9e90f;
            line-height: 1;
            margin-bottom: 20px;
            text-shadow: 0 0 20px rgba(169, 233, 15, 0.3);
        }
        .error-message {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 15px;
            text-transform: uppercase;
        }
        .error-description {
            color: #ccc;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        .btn-home {
            background-color: #a9e90f;
            color: #000;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 800;
            text-transform: uppercase;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            display: inline-block;
        }
        .btn-home:hover {
            background-color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(169, 233, 15, 0.4);
        }
        .logo {
            margin-bottom: 40px;
            width: 150px;
        }
        .background-blur {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 50% 50%, rgba(169, 233, 15, 0.1) 0%, rgba(0,0,0,0) 70%);
            z-index: -1;
        }
    </style>
</head>
<body>
    <div class="background-blur"></div>
    <div class="container">
        <a href="/">
            <img src="{{ asset('images/logo.png') }}" alt="Trade Like Okafor" class="logo">
        </a>
        <div class="error-code">@yield('code')</div>
        <div class="error-message">@yield('message')</div>
        <div class="error-description">@yield('description')</div>
        <a href="/" class="btn-home">Back to Home</a>
    </div>
</body>
</html>
