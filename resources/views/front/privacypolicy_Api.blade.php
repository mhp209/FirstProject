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
    <link rel="stylesheet" href="{{ CSSVersion('front_assets/css/style.css') }}">

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

    <!-- <div class="loader-main">
        <div class="loader">
        <div class="images text-center ">
            <img src="{{ asset('front_assets/images/loader.webp') }}" alt="">
        </div>
        </div>
    </div> -->

    <section id="privacy-policy-section">
        <div class="container">
            <div class="title text-center ">
                <h1>Privacy-policy</h1>
            </div>
        </div>
    </section>

    <section id="privacy-content">
        <div class="container">
            <div class="content-wrapper">
                <h3>Information Collection and Use</h3>
                <p> Company Name operates the Website Name website, which provides the SERVICE.
                    This page is used to inform website visitors regarding our policies with the collection, use, and disclosure of Personal Information if anyone decided to use our Service, the Website Name website.
                    If you choose to use our Service, then you agree to the collection and use of information in relation with this policy. The Personal Information that we collect are used for providing and improving the Service. We will not use or share your information with anyone except as described in this Privacy Policy.
                    The terms used in this Privacy Policy have the same meanings as in our Terms and Conditions, which is accessible at Website URL, unless otherwise defined in this Privacy Policy.</p>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="content-wrapper">
                        <h3>Information Collection and Use</h3>
                        <p>For a better experience while using our Service, we may require you to provide us with certain personally identifiable information, including but not limited to your name, phone number, and postal address. The information that we collect will be used to contact or identify you.</p>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="content-wrapper">
                        <h3>Log Data</h3>
                        <p>We want to inform you that whenever you visit our Service, we collect information that your browser sends to us that is called Log Data. This Log Data may include information such as your computer's Internet Protocol (“IP”) address, browser version, pages of our Service that you visit, the time and date of your visit, the time spent on those pages, and other statistics.</p>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="content-wrapper">
                        <h3>Cookies</h3>
                        <p>Cookies are files with small amount of data that is commonly used an anonymous unique identifier. These are sent to your browser from the website that you visit and are stored on your computer's hard drive.</p>
                        <p> Our website uses these “cookies” to collection information and to improve our Service. You have the option to either accept or refuse these cookies, and know when a cookie is being sent to your computer. If you choose to refuse our cookies, you may not be able to use some portions of our Service.</p>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="content-wrapper">
                        <h3>Security</h3>
                        <p>We value your trust in providing us your Personal Information, thus we are striving to use commercially acceptable means of protecting it. But remember that no method of transmission over the internet, or method of electronic storage is 100% secure and reliable, and we cannot guarantee its absolute security.</p>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="content-wrapper">
                        <h3>Refund Policy</h3>
                        <p>Road Sathi exclusively offers the RS Safety Tag, a versatile sticker suitable for all types of vehicles, including two-wheelers, four-wheelers, trucks, autos, and more. Our product eliminates concerns related to size, color, sticker type, and material, ensuring a seamless experience for every user. Please note that due to the comprehensive nature of our product, we do not entertain refund requests. However, if a customer encounters any issues such as damage to the tag, they can reach out to our customer care hotline or email us for a prompt replacement. We guarantee a hassle-free replacement process with the issuance of the same code of sticker. Your satisfaction and safety are our top priorities at Road Sathi.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>

</html>
