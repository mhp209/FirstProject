@extends('front.layout.master')

@section('content')

    <section id="about-us-banner">
        <div class="container ">
            <div class="section-title text-center ">
                <h1>insurance</h1>
            </div>
        </div>
    </section>


    <section id="insurance-section">
        <div class="container">
            <div class="row gy-4">
                @if (count($insurances) > 0)
                    @foreach ($insurances as $key => $insurance)

                        <div class="col-lg-4">
                            <div class="car-insurance">
                                <a href="#">
                                    <img src="{{ INSURANCE_IMAGE . $insurance->image }}" alt="" class="img-fluid">
                                    <h3> {{ $insurance->name }}</h3>
                                </a>
                                <a href="{{route('insurance.details', $insurance->alias)}}" class="buy-qr-btn">
                                    Read More
                                </a>
                            </div>
                        </div>

                    @endforeach
                @else
                    <p class="text-center">No Insurance Added</p>
                @endif
            </div>
        </div>
    </section>

    <section id="gallery-section">
        <div class="container-fluid">
            <div class="row">
                <div class="section-title text-center ">
                    <h1>Our Association with</h1>
                </div>
                <div id="gallery-slider-1" class="gallery-slider gap-3">
                    <div class="images-insur">
                        <img src="{{ asset('partners/logo-acko.png') }}" alt="">
                    </div>
                    <div class="images-insur">
                        <img src="{{ asset('partners/logo-aditya-birla-health.png') }}" alt="">
                    </div>
                    <div class="images-insur">
                        <img src="{{ asset('partners/logo-bajaj-general.png') }}" alt="">
                    </div>
                    <div class="images-insur">
                        <img src="{{ asset('partners/logo-chola.png') }}" alt="">
                    </div>
                    <div class="images-insur">
                        <img src="{{ asset('partners/logo-edelweiss-tokio-life.png') }}" alt="">
                    </div>
                    <div class="images-insur">
                        <img src="{{ asset('partners/logo-future-generali.png') }}" alt="">
                    </div>
                    <div class="images-insur">
                        <img src="{{ asset('partners/logo-iffco-tokio.png') }}" alt="">
                    </div>
                    <div class="images-insur">
                        <img src="{{ asset('partners/logo-new-india-insurance.png') }}" alt="">
                    </div>
                    <div class="images-insur">
                        <img src="{{ asset('partners/logo-oriental.png') }}" alt="">
                    </div>
                    <div class="images-insur">
                        <img src="{{ asset('partners/logo-shriram-general.png') }}" alt="">
                    </div>
                    <div class="images-insur">
                        <img src="{{ asset('partners/logo-star-health.png') }}" alt="">
                    </div>
                    <div class="images-insur">
                        <img src="{{ asset('partners/logo-tata-aia-life.png') }}" alt="">
                    </div>
                    <div class="images-insur">
                        <img src="{{ asset('partners/logo-united-india.png') }}" alt="">
                    </div>
                    <div class="images-insur">
                        <img src="{{ asset('partners/zuno.png') }}" alt="">
                    </div>
                    <div class="images-insur">
                        <img src="{{ asset('partners/logo-reliance-general.png') }}" alt="">
                    </div>
                    <div class="images-insur">
                        <img src="{{ asset('partners/logo-pnb-metlife.png') }}" alt="">
                    </div>
                    <div class="images-insur">
                        <img src="{{ asset('partners/logo-national-insurance.png') }}" alt="">
                    </div>
                    <div class="images-insur">
                        <img src="{{ asset('partners/logo-digit.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 calss="">Why Insurance Buy from Road Sathi</h5>
                    <div class="benefits">
                        <ul>
                            <li class="gap-2 ">
                                <img src="{{ asset('front_assets/images/check-2.png')}}" alt="" width="24" height="24">
                                <p class="mb-0">People can buy all types of Insurance from one window</p>
                            </li>
                            <li class="gap-2 ">
                                <img src="{{ asset('front_assets/images/check-2.png')}}" alt="" width="24" height="24">
                                <p class="mb-0">Compare all companies' policy benefits and Prices simultaneously.</p>
                            </li>
                            <li class="gap-2 ">
                                <img src="{{ asset('front_assets/images/check-2.png')}}" alt="" width="24" height="24">
                                <p class="mb-0">Get Quick, easy &amp; hassle-free process</p>
                            </li>
                            <li class="gap-2 ">
                                <img src="{{ asset('front_assets/images/check-2.png')}}" alt="" width="24" height="24">
                                <p class="mb-0">Instant and 100% on-call support with a customer care number.</p>
                            </li>
                            <li class="gap-2 ">
                                <img src="{{ asset('front_assets/images/check-2.png')}}" alt="" width="24" height="24">
                                <p class="mb-0">Receive cashback or attractive offer vouchers on the booking of any Insurance</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer justify-content-center align-items-center ">
                    <button type="submit" class="call-btn">
                        <a href="tel:987 987 5066"> Call Now</a>
                    </button>
                    <form method="POST" action="{{ route('insName') }}">
                        @csrf
                        <input type="hidden" name="name" id='name' value="" />
                        <input type="hidden" name="alias" id='alias' value="" />
                        <a href="">
                            <button type="submit" class="request-call-back-btn">
                                Request a Call back
                            </button>
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>

@if ($message = Session::get('success'))
<div class="modal fade show" id="thankyouModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Insurance </h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-center align-items-center">
                    <div class="card col-md-12 bg-white shadow-md p-5">
                        <div class="text-center">
                            <h1>Thank You !</h1>
                            <p>We've got your enquiry. Our respective person contact you.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary call-btn" data-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@section('scripts')
<script src="{{ asset('front_assets/js/client-jquery-2.2.0.min.js') }}" defer></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" defer></script>
<script src="{{ asset('front_assets/js/client-slick.js') }}" defer></script>
<script src="{{ asset('front_assets/custom_js/insurance.js') }}" defer></script>
@endsection
