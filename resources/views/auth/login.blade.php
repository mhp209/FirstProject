@extends('front.layout.master')

@section('content')
<section id="loing-form">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                @php
                    if(url()->previous() != (SITE_URL.'login')){
                        $page = str_replace(SITE_URL,"/",url()->previous());
                        session()->put('previous_page',$page);
                    }
                @endphp
                <form method="POST" action="{{ route('login') }}" id="frmlogin">
                    @csrf
                    <div class="form-wrapper">
                        <h2 class="text-center mb-4">Welcome to <Span>Road Sathi</Span></h2>
                        <div class="mobile-number">
                            <label class="justify-content-center align-items-center ">
                                <span class="material-symbols-outlined">
                                    call
                                </span>
                            </label>
                            <input type="number" min="0" name="mobile_number" class="form-control @error('mobile_number') is-invalid @enderror" value="{{ old('mobile_number') }}" placeholder="Mobile Number" autocomplete="mobile_number" autofocus>
                            @error('mobile_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="password">
                            <label class="justify-content-center align-items-center ">
                                <span class="material-symbols-outlined">
                                    lock
                                </span>
                            </label>
                            <input type="password" placeholder="Password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password">
                            <i class="fa fa-eye-slash" id="Passwordtoggle"></i>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>

                        <p class="text-end">
                            <a href="{{ url('password/reset') }}">
                                Forgot Password ?
                            </a>
                        </p>
                        <div class="">
                            <button type="submit"> Login </button>
                        </div>
                        <div class="account-content">
                            <p>Don't have an account?</p>
                        </div>
                        <a href="{{ route('register') }}" style="text-decoration: none; color:#1a6db7">
                            <div class="sign-up text-center">
                                Sign up
                            </div>
                        </a>
                    </div>
                </form>
            </div>
            <div class="col-lg-7">
                <div class="images text-center ">
                    <img src="{{ asset('front_assets/images/login-form.jpg') }}" alt="" class="img-fluid ">
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.4.min.js" defer></script>
<script src="{{ asset('front_assets/js/jquery.validate.min.js') }}" defer></script>
<script src="{{ asset('front_assets/custom_js/login.js') }}" defer></script>
@endsection
