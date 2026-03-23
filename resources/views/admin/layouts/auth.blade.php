<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Road Sathi</title>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
		<!-- Main CSS -->
        <link rel="stylesheet" href="{{ asset('admin_assets/css/style.css') }}">
		<!-- Favicon -->
        @php
            $svgFile = public_path('admin_assets/img/favicon.svg');
            $svgContent = file_get_contents($svgFile);
            $base64Encoded = 'data:image/svg+xml;base64,' . base64_encode($svgContent);
        @endphp

        <link rel="shortcut icon" href="{{ $base64Encoded }} " type="image/x-icon">
        <link rel="icon" href="{{ $base64Encoded }}" type="image/x-icon">
        <!-- <link rel="shortcut icon" type="image/x-icon" href="{{ asset('admin_assets/img/favicon.ico') }}"> -->
        <script>
            var site_url = '{{ SITE_URL }}';
        </script>
    </head>
    <body class="account-page">

		<!-- Main Wrapper -->
        <div class="main-wrapper">
			<div class="account-content">
				<!-- <a href="job-list.html" class="btn btn-primary apply-btn">Apply Job</a> -->
				<div class="container">

					<!-- Account Logo -->
					<div class="account-logo">
						<a href=""><img src="{{ asset('admin_assets/img/logo.png') }}" alt="Road Sathi"></a>
					</div>
					<!-- /Account Logo -->

					<div class="account-box">
                        @yield('content')
					</div>
				</div>
			</div>
        </div>
		<!-- /Main Wrapper -->
        @yield('script')
    </body>
</html>
