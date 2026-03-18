@extends('front.layout.master')

@section('css')
<!-- <style type="text/css">
    button {
        text-decoration: none;
        color: #1a6db7;
        font-size: 18px;
        font-weight: 500;
        border: 1px solid #1a6db7;
        padding: 12px 32px;
        border-radius: 30px;
    }
</style> -->
@endsection

@section('content')

<section id="about-us-banner">
    <div class="container ">
        <div class="section-title text-center ">
            <h1>Contact Us</h1>
        </div>
</section>

<section id="contact-us-form">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>{{ $message }}</strong>
                </div>
                @endif
                @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>{{ $message }} </strong>
                </div>
                @endif
                <form method="post" action="{{ route('contact.us')}}" id="contact_us">
                    @csrf
                    <div class="form-wrapper">
                        <div class="row">
                            <div class="col-lg-6 first-name">
                                <label class="justify-content-center align-items-center ">
                                    <span class="material-symbols-outlined">
                                        person
                                    </span>
                                </label>
                                <input type="text" name="first_name" class="@error('first_name') is-invalid @enderror" placeholder="First Name">
                                @error('message')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class=" col-lg-6 last-name">
                                <label class="justify-content-center align-items-center ">
                                    <span class="material-symbols-outlined">
                                        person
                                    </span>
                                </label>
                                <input type="text" name="last_name" class="@error('last_name') is-invalid @enderror" placeholder="Last Name">
                                @error('message')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-lg-6 mobile-number">
                                <label class="justify-content-center align-items-center ">
                                    <span class="material-symbols-outlined">
                                        call
                                    </span>
                                </label>
                                <input type="number" min=0 name="mobile_number" class="@error('mobile_number') is-invalid @enderror" placeholder="Mobile Number">
                                @error('message')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-lg-6 email-wrapper">
                                <label class="justify-content-center align-items-center ">
                                    <span class="material-symbols-outlined">
                                        mail
                                    </span>
                                </label>
                                <input type="text" name="email" class="@error('email') is-invalid @enderror" placeholder="Email">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-lg-12 massage-box">
                                <textarea name="message" placeholder="Message" class="@error('message') is-invalid @enderror" id="" cols="10" rows="4"></textarea>
                                @error('message')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="sign-up text-center ">
                                <button type="submit">Submit</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="col-lg-6 my-auto">
                <div class="support-wrapper">
                    <div class="row email-wrapper-boxing">
                        <div class="col-lg-6">
                            <div class="email-wrapper-box text-center">
                                <a href="#" class="">
                                    <div class="icon">
                                        <span class="material-symbols-outlined">
                                            mail
                                        </span>
                                    </div>
                                    <div class="email-content">
                                        <h5>Email Support</h5>
                                    </div>
                                    <div class="email-id">
                                        <h4>{{ MAIL }}</h4>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-6 ">
                            <div class="email-wrapper-box text-center">
                                <a href="#" class="">
                                    <div class="icon">
                                        <span class="material-symbols-outlined">
                                            smartphone
                                        </span>
                                    </div>
                                    <div class="email-content">
                                        <h5>Sales</h5>
                                    </div>
                                    <div class="email-id">
                                        <h4>{{ SALES_NO }}</h4>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-6 ">
                            <div class="email-wrapper-box text-center">
                                <a href="#" class="">
                                    <div class="icon">
                                        <span class="material-symbols-outlined">
                                            smartphone
                                        </span>
                                    </div>
                                    <div class="email-content">
                                        <h5>Contact</h5>
                                    </div>
                                    <div class="email-id">
                                        <h4>{{ MOBILE_NO }}</h4>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6 ">
                            <div class="email-wrapper-box text-center">
                                <a href="#" class="">
                                    <div class="icon">
                                        <span class="material-symbols-outlined">
                                            location_on
                                        </span>
                                    </div>
                                    <div class="email-content">
                                        <h5>Location</h5>
                                    </div>
                                    <div class="email-id">
                                        <h4>{{ LOCATION }}</h4>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    window.addEventListener('load', function() {
        loadJS("{{ asset('front_assets/js/jquery.validate.min.js') }}");
        loadJS("{{ asset('front_assets/custom_js/contact.js') }}");
    });
</script>
@endsection
