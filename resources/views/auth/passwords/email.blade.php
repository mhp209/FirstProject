@extends('front.layout.master')

@section('css')
<!-- <style type="text/css">
    button {
        text-decoration: none;
    color: #fff;
    font-size: 18px;
    font-weight: 500;
    border: 1px solid #1a6db7;
    padding: 10px 20px;
    border-radius: 30px;
    background: #1a6db7;
    transition: 0.3s ease-in-out;
    border: 1px transparent;
    }
    button:hover{
        background: transparent;
        border: 1px solid #1a6db7;
        color: #1a6db7;
        border-radius: 0 12px;
    } -->
</style>
@endsection

@section('content')


<section id="section-title-name">
    <div class="container ">
        <div class="title text-center ">
            <h1>Forget Password</h1>
        </div>
    </div>

</section>
<section id="reset-password-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 my-auto">
                <div class="forget-password-wrapper">
                @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('password.email') }}" id="form_register">
                        @csrf
                        <div class="form-wrapper">
                            <div class="row">
                                <div class="col-lg-0 email-address">
                                    <h5>Email<span class="text-danger">*</span></h5>
                                    <label class="justify-content-center align-items-center ">
                                        <span class="material-symbols-outlined">
                                            mail
                                        </span>
                                    </label>
                                    <input type="email" id="email" placeholder="Email Address" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="password-btn text-center">
                                    <button type="submit">Send Password Reset Link</button>
                                    <!-- <a href="#">Send Password Reset Link</a> -->
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-6  ">
                <div class="images">
                    <img src="{{ asset('front_assets/images/forget-password.png') }}" alt="" class="img-fluid ">
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')

<script src="{{ asset('front_assets/js/jquery.validate.min.js') }}" defer></script>
<script src="{{ asset('front_assets/custom_js/register.js') }}" defer></script>

@endsection
