<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Road Sathi</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <link rel="shortcut icon" href="{{ asset('front_assets/images/favicon.ico') }} " type="image/x-icon">
    <!-- <link rel="icon" href="{{ asset('front_assets/images/favicon.ico') }}" type="image/x-icon"> -->
    @php
    $svgFile = asset('front_assets/images/favicon.svg');
    $svgContent = file_get_contents($svgFile);
    $base64Encoded = 'data:image/svg+xml;base64,' . base64_encode($svgContent);
    @endphp

    <link rel="shortcut icon" href="{{ $base64Encoded }} " type="image/x-icon">
    <link rel="icon" href="{{ $base64Encoded }}" type="image/x-icon">

    <link rel="stylesheet" href="{{ asset('front_assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('front_assets/css/responsive.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <script>
        var site_url = '<?= SITE_URL ?>';
    </script>
</head>

<body>
    <section id="header-section">
        <div class="images">
            <img src="{{ asset('front_assets/images/road-sathi-logo-white.webp') }}" alt="" width="100px">
        </div>
    </section>

    <section id="checkout-banner">
        <div class="container ">
            <div class="section-title text-center ">
                <h1>Check out</h1>
            </div>
    </section>

    <section id="checkout-section">
        <div class="container">

            <div class="container">
                @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <!-- <button type="button" class="close" data-bs-dismiss="alert"><i class="fs-6 far fa-times-circle"></i></button> -->

                    <span class="material-symbols-outlined" class="close" data-bs-dismiss="alert">
                        close
                    </span>

                    <strong>{{ $message }}</strong>
                </div>
                @endif
                @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-bs-dismiss="alert"><i class="fs-6 far fa-times-circle"></i></button>
                    <strong>{{ $message }} </strong>
                </div>
                @endif
            </div>


            <div class="row gy-3">
                <div class="col-lg-8 order-2 order-lg-2 mt-3 mt-lg-0">
                    <h3>select a delivery Address </h3>
                    <div class="billing-datelis-wrapper">

                    <form id="checkout_frm" method="post" action="{{ route('order') }}" enctype="multipart/form-data">
                        @csrf
                        @php
                            $road_sathi_address_id = session()->get('road_sathi_address_id');
                            $Addresses = GetAddresses();
                            if(!empty($road_sathi_address_id)){
                                $default_add = $road_sathi_address_id;
                            }else{
                                if(!empty($Addresses)){
                                    $default_add = GetAddresses(['is_default' => 1]);
                                    if(empty($default_add)){
                                        $default_add = $Addresses[0]['id'];
                                    }
                                }
                            }
                        @endphp

                        @foreach($Addresses as $add)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="address_id" name="address_id" value="{{ $add['id'] }}"
                                    id="flexRadioDefault1" {{ ($add['id'] == $default_add)? 'checked' : ''}}>
                                <label class="form-check-label" for="flexRadioDefault1">
                                    <b>{{ ucfirst($add['first_name'])." ".ucfirst($add['last_name']) }}</b>
                                    <p class='p-0'> {{ $add['add1'].", ".$add['add2'] }}
                                     {{ $add['city'].", ".$add['state'] .", ".$add['pincode'].", ".$add['country'] }}
                                    </p>
                                    <p class='p-0'> {{ $add['mobile_number'] }} </p>
                                    <p class='p-0'> {{ $add['email'] }} </p>
                                    <button type="button" class="gap-2 edit-address" data-id="{{ $add['id'] }}"><span class="material-symbols-outlined">
                                            edit
                                        </span>edit address</button>
                                </label>
                            </div>
                        @endforeach
                        <a class="add-new-address-btn add-address"
                            role="button"><span class="material-symbols-outlined">
                                add
                            </span>Add a New Address
                        </a>
                        <hr class="mb-4">
                        <button type="submit" class="continue-to-payment-btn  btn-block" onClick="this.disabled = true;">Pay Now</button>
                        <a href="{{route('cart') }}" class="back-to-cart-btn" >back to cart</a>
                    </form>
                    </div>
                </div>
                <div class="col-lg-4 order-1 order-lg-2">
                    <div class="summery">
                        <h5>Order Items</h5>
                        <hr>
                        <div class="order-details-price">
                            <div class="images text-center">
                                <img src="{{ asset('front_assets/images/RS-Safety-Tag.png') }}" alt=""
                                    class="img-fluid">
                            </div>
                            <h4>RS Safety Tag</h4>

                            <ul>
                                <li class="d-flex ">products Quantity<span> {{ $quantity }} </span></li>

                                <li class="d-flex ">products Price<span> ₹ {{ RS_SAFETY_PRICE }}</span></li>
                                <hr>
                                <li class="d-flex">
                                    <div class="total-amount">
                                        <storang>Sub Amount </storang>
                                    </div>
                                    <span class="price-total">
                                        <storang>₹</storang>
                                        <span>
                                            <storang>{{ price_format($price) }}</storang>
                                        </span>
                                    </span>
                                </li>
                                @if(!empty($discount))
                                    <li class="d-flex ">PromoCode ({{ $code }}) <span id="discount"> - ₹ {{ price_format($discount) }}</span></li>
                                @endif
                                <hr>
                                @php
                                    $total_amount = $price - $discount;
                                @endphp
                                <li class="d-flex">
                                    <div class="total-amount">
                                        <storang>Total Amount </storang>
                                    </div>
                                    <span class="price-total">
                                        <storang>₹</storang>
                                        <span>
                                            <storang>{{ price_format($total_amount) }}</storang>
                                        </span>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

    <div class="modal fade" id="AddressModel" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Address</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="AddressBody">

                </div>
            </div>
        </div>
    </div>

    <section id="footer" style="padding: 0px;">
        <footer>
            <hr>
            <section id="footer-row" class="">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 ">
                            <div class="right-reservad">
                                <p>@ {{ now()->year }} All right reserved by Kinix Infotech Pvt. Ltd</p>
                            </div>
                        </div>
                        <div class="col-lg-6 text-end ">
                            <div class="terms-wrapper">
                                <a href="{{ url('termscondition') }}">Terms & Conditions</a>
                                |
                                <a href="{{ url('privacypolicy') }}">Privacy Policy</a>
                            </div>
                        </div>
                    </div>



                </div>

            </section>
        </footer>

    </section>

    <script src="{{ asset('front_assets/js/main.js') }}"></script>
    <script src="{{ asset('front_assets/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('front_assets/custom_js/checkout.js') }}"></script>


</body>

</html>
