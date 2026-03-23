<!-- Favicon -->
@php
    $svgFile = public_path('admin_assets/img/favicon.svg');
    $svgContent = file_get_contents($svgFile);
    $base64Encoded = 'data:image/svg+xml;base64,' . base64_encode($svgContent);
@endphp

<link rel="shortcut icon" href="{{ $base64Encoded }} " type="image/x-icon">
<link rel="icon" href="{{ $base64Encoded }}" type="image/x-icon">

<link rel="stylesheet" href="{{ asset('admin_assets/css/bootstrap.min.css') }}">
		<!-- Fontawesome CSS -->
<link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
		<!-- Lineawesome CSS -->
<link rel="stylesheet" href="{{ asset('css/line-awesome.min.css') }}">

<link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/scroller.dataTables.min.css') }}">

<!-- Main CSS -->
<link rel="stylesheet" href="{{ asset('admin_assets/css/style.css') }}">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css">

<script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('admin_assets/js/flatpickr.min.js') }}"></script>

<script src="{{ asset('admin_assets/js/popper.min.js') }}"></script>
<script src="{{ asset('admin_assets/js/bootstrap.min.js') }}"></script>
<!-- <script src="{{ asset('admin_assets/js/dataTables.responsive.min.js') }}"></script>  -->



