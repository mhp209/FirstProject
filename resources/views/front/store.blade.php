@extends('front.layout.master')

@section('css')
<link rel="stylesheet" href="{{ asset('front_assets/css/aos.css') }}">
@endsection

@section('content')

<section id="about-us-banner">
    <div class="container ">
        <div class="section-title text-center ">
            <h1>Products</h1>
        </div>
</section>

<section id="store-section">
    <div class="container">
        <div class="row gy-3">
            <!-- <div class="section-title text-center ">
                <h1>products</h1>
            </div> -->
            <div class="col-lg-6 road-sathi-qr-code-wrapper-box" data-aos="flip-left" data-aos-easing="ease-out-cubic" data-aos-duration="2000">
                <div class="road-sathi-qr-code-wrapper">
                    <div class="images">
                        <img src="{{ asset('front_assets/images/RS-Safety-Tag.png') }}" alt="" class="img-fluid ">
                    </div>
                    <div class="title">
                        <h4>RS Safety Tag </h4>
                        <div class="price">
                            <h3>₹ {{ RS_SAFETY_PRICE }}</h3>
                        </div>
                    </div>
                    <div class="discount-content">
                        <h3>Get more 15% discount on mrp on the purchase of 3 qr’s</h3>
                    </div>
                    <a href="{{ route('product') }}">
                        <button type="submit" class="buy-qr-btn">
                            View
                        </button>
                    </a>
                </div>
            </div>
            <div class="col-lg-6 insurance-wrapper-box" data-aos="flip-left" data-aos-easing="ease-out-cubic" data-aos-duration="2000">
                <div class="insurance-wrapper">
                    <div class="images">
                        <img src="{{ asset('front_assets/images/product-img-1.png') }}" alt="" class="img-fluid ">
                    </div>
                    <div class="title">
                        <h4>insurance</h4>
                        <!-- <div class="price">
                                <h3>₹ 599</h3>
                            </div> -->
                    </div>
                    <div class="discount-content" style="">
                        <h3>Get more 15% discount on mrp on the purchase of 3 qr’s</h3>
                    </div>
                    <a href="{{ route('insurance') }}">
                        <button type="submit" class="buy-qr-btn">
                            Get Quote
                        </button>
                    </a>
                    {{-- <button href="#" class="buy-qr-btn" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        Get Quote
                    </button> --}}
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Insurance </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5>Why Insurance Buy from Road Sathi</h5>
                <div class="benefits gap-5">
                <ul>
                    <li class="gap-2 "> <span class="material-symbols-outlined">
                            done
                        </span>People can buy all types of Insurance from one window</li>
                    <li class="gap-2 "> <span class="material-symbols-outlined">
                            done
                        </span>Compare all companies' policy benefits and Prices simultaneously.</li>
                    <li class="gap-2 "> <span class="material-symbols-outlined">
                            done
                        </span>Get Quick, easy & hassle-free process</li>
                    <li class="gap-2 "> <span class="material-symbols-outlined">
                            done
                        </span>Instant and 100% on-call support with a customer care number.</li>
                    <li class="gap-2 "> <span class="material-symbols-outlined">
                            done
                        </span>Receive cashback or attractive offer vouchers on the booking of any Insurance</li>
                </ul>
                </div>
            </div>
            <div class="modal-footer justify-content-center align-items-center ">
                <button type="submit" class="call-btn">
                    <a href="#"> Call Now</a>
                </button>
                <a href="{{ route('request.callback.insurance') }}">
                    <button type="submit" class="request-call-back-btn">
                        Request a Call back
                    </button>
                </a>
            </div>
        </div>
    </div>
</div>



@endsection

@section('scripts')
<script src="{{ asset('front_assets/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('front_assets/custom_js/store.js') }}"></script>
<script src="{{ asset('front_assets/js/aos.js') }}"></script>
<script src="{{ asset('front_assets/js/height.js') }}"></script>
<script>
    AOS.init({
        disable: function() {
            var maxwidth = 800;
            var isMobile = /Mobi|Android/i.test(navigator.userAgent);
            return window.innerWidth < maxwidth || isMobile;
        },
    });
</script>
<script>
    jQuery(
        ".road-sathi-qr-code-wrapper-box .road-sathi-qr-code-wrapper"
    ).matchHeight();
</script>
<script>
    jQuery(
        ".insurance-wrapper-box .insurance-wrapper"
    ).matchHeight();
</script>


@endsection
