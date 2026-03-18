<!-- resources/views/thankyou.blade.php -->

@extends('front.layout.master')

@section('content')
<!-- <div class="container">
        <h2>Thank You!</h2>
        <p>Your order has been placed successfully.</p>
        @if($message = Session::get('message'))
                <p>{!! $message !!}</p>
        @endif
    </div> -->

<section id="thank-you-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 my-auto ">
                <div class="thank-you-content">
                    <h1>Thank You!</h1>
                    <p>Order has been placed successfully</p>
                    <p>Please Check Your Email For Confirmation And Order details.</p>
                    <p>For Any Question & Concerns Please Contact: </p>
                    <a href="#">
                        <span class="material-symbols-outlined">
                            mail
                        </span>
                        support@roadsathi.com
                    </a>
                </div>
                <div class="back-btn-content">
                    <a href="{{ route('product') }}">Back to Store</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="images text-center ">
                    <img src="{{ asset('front_assets/images/thank-you-img.png') }}" alt="" class="img-fluid" width="450" height="350">
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
