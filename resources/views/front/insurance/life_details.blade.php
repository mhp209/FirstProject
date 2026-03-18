@extends('front.layout.master')

@section('content')

<section id="about-us-banner">
    <div class="container ">
        <div class="section-title text-center ">
            <h1>insurance</h1>
        </div>
    </div>
</section>

<section id="car-insurance-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="images">
                    <img src="{{ asset('front_assets/images/Insurance/life-insurance.png') }}" alt="" class="img-fluid" width="400" height="400">
                </div>
            </div>
            <div class="col-lg-6 my-auto">
                <div class="car-insurance-content ">
                    <h3>What is Life Insurance?</h3>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                    </p>
                </div>
                <div class="add-cart-btn ">
                    <button href="#" class="buy-qr-btn getQuote" data-alias="life-insurance" data-name="Life Insurance">
                        Get Quote
                    </button>
                </div>
            </div>

        </div>
    </div>
</section>

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
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
                <button type="submit" class="call-btn d-md-block d-none">
                    <a href="{{ route('contact') }}"> Contact us</a>
                </button>
                <button type="submit" class="call-btn d-md-none">
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
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                <button type="button" class="btn btn-secondary call-btn" data-bs-dismiss="modal">
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

