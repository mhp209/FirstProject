<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Road Sathi</title>

    @php
    $svgFile = asset('front_assets/images/favicon.svg');
    $svgContent = file_get_contents($svgFile);
    $base64Encoded = 'data:image/svg+xml;base64,' . base64_encode($svgContent);
    @endphp

    <link rel="shortcut icon" href="{{ $base64Encoded }} " type="image/x-icon">
    <link rel="icon" href="{{ $base64Encoded }}" type="image/x-icon">

    <!-- Css -->
    <link rel="stylesheet" href="{{ CSSVersion('front_assets/css/style.css') }}" >

    <link rel="stylesheet" href="{{ asset('front_assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('front_assets/css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('front_assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('front_assets/css/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('front_assets/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('front_assets/css/material_icon.css') }}" />
    <link rel="stylesheet" href="{{ asset('front_assets/css/aos.css') }}" />

    <!-- Jquery  -->
    <script src="{{ asset('front_assets/js/jquery.min.js') }}" defer></script>
    <script src="{{ asset('front_assets/js/bootstrap/bootstrap.min.js') }}" defer></script>
    <script>
        var site_url = '<?= SITE_URL; ?>';
    </script>
</head>

<body>

    <div class="loader-main">
        <div class="loader">
        <div class="images text-center ">
            <img src="{{ asset('front_assets/images/loader.webp') }}" alt="">
        </div>
        </div>
    </div>

    <header id="navbar">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('front_assets/images/road-sathi-logo-white.webp') }}" alt="" width="100" height="50">
                </a>
                <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse ms-auto" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-0 mb-lg-0">
                        <li class="nav-item">
                            <a class="lora home-link nav-link  nav-link @if(Session::get('module') == 'home') active @endif" aria-current="page" href="{{ SITE_URL }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="home-link nav-link nav-link @if(Session::get('module') == 'about') active @endif" href="{{ route('about') }}">About Us</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="home-link nav-link nav-link @if(Session::get('module') == 'store') active @endif" href="{{ route('store') }}">Store</a>
                        </li> -->
                        <div class="product">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle gap-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    products
                                </a>
                                <ul class="dropdown-menu text-center">
                                    <li><a class="dropdown-item" href="{{ route('product') }}">RS Safety Tag</a></li>
                                    <li><a class="dropdown-item" href="{{ route('insurance') }}">Insurance</a></li>
                                    <li><a class="dropdown-item" href="{{ route('hire.cab') }}">Hire Cab</a></li>
                                    <li><a class="dropdown-item" href="{{ route('hire.bus') }}">Hire Bus</a></li>

                                </ul>
                            </li>
                        </div>
                        <li class="nav-item">
                            <a class="home-link nav-item nav-link @if(Session::get('module') == 'contact') active @endif" href="{{ route('contact') }}">Contact Us</a>
                        </li>
                    </ul>
                    <div class="profile">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="material-symbols-outlined">
                                    account_circle
                                </span>
                            </a>
                            <ul class="dropdown-menu">
                                @guest
                                <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
                                <li><a class="dropdown-item" href="{{ route('register.form') }}">Register Now</a></li>
                                @else
                                <li><a class="dropdown-item">Hello {{ ucfirst(Auth::user()->first_name)}} !</a></li>
                                <li><a class="dropdown-item" href="{{ route('my_account') }}">My Account</a></li>
                                <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                                @endguest
                            </ul>
                        </li>
                    </div>
                    <div class="cart-icon ">
                        <a href="{{ route('cart') }}">
                            <span class="material-symbols-outlined">
                                shopping_cart
                            </span>
                            @php
                                if(Session::has('road_sathi_cart')){
                                    $cart = session()->get('road_sathi_cart');
                                    $quantity = (isset($cart['products'])) ? array_sum($cart['products']) : '';
                                }else{
                                    $quantity = 0;
                                }
                            @endphp
                            @if($quantity > 0)
                                <span class="cart-count" id="cart-count">{{ $quantity }}</span>
                            @endif
                        </a>
                    </div>
                </div>

            </div>
        </nav>
    </header>
    <!-- <main> -->
