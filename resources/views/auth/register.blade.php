@extends('front.layout.master')

@section('content')

<section id="registration-form">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                @if(!session('verification_code'))
                <form method="POST" action="{{ route('register') }}" id="form_register" enctype="multipart/form-data">
                    @csrf
                    <div class="form-wrapper text-center  ">
                        <h2 class="text-center ">Registration</h2>
                        <div class="row">
                            <div class="col-lg-6 first-name">
                                <label class="justify-content-center align-items-center ">
                                    <span class="material-symbols-outlined">
                                        person
                                    </span>
                                </label>
                                <input type="text" name="first_name" value="{{ old('first_name') }}" class="@error('first_name') is-invalid @enderror" placeholder="First name">
                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-lg-6 last-name">
                                <label class="justify-content-center align-items-center ">
                                    <span class="material-symbols-outlined">
                                        person
                                    </span>
                                </label>
                                <input type="text" name="last_name" value="{{ old('last_name') }}" class="@error('last_name') is-invalid @enderror" placeholder="Last name">
                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-lg-6 mobile-number">
                                <label class="justify-content-center">
                                    <span class="material-symbols-outlined">
                                        call
                                    </span>
                                </label>
                                <input type="number" name="mobile_number" value="{{ old('mobile_number') }}" min=0 class="@error('mobile_number') is-invalid @enderror" id="mobile_number" placeholder="Mobile Number">
                                @error('mobile_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-lg-6 email-wrapper">
                                <label class="justify-content-center  ">
                                    <span class="material-symbols-outlined">
                                        mail
                                    </span>
                                </label>
                                <input type="text" name="email" id="email" value="{{ old('email') }}" class="@error('email') is-invalid @enderror" placeholder="Email">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-lg-6 password eyeicon">
                                <label class="justify-content-center">
                                    <span class="material-symbols-outlined">
                                        lock
                                    </span>
                                </label>
                                <input type="password" name="password" id="password" class="@error('password') is-invalid @enderror" placeholder="Password">
                                <i class="fa fa-eye-slash" id="Passwordtoggle"></i>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-lg-6 confirm-password">
                                <label class="justify-content-center align-items-center ">
                                    <span class="material-symbols-outlined">
                                        lock
                                    </span>
                                </label>
                                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" required>
                                <!-- <div class="fa fa-eye icon" id="show-password"></div> -->
                            </div>
                            <div class="form-check input-group">
                                <input type="checkbox" id="terms_and_policy" name="terms_and_policy" class="form-check-input me-2 " autocomplete="terms_and_policy">
                                <label class="form-check-label" for="terms_and_policy">I Accept all terms &amp; policy</label>
                            </div>
                            <div class="sign-up">
                                <button type="submit">Sign up</button>
                            </div>
                        </div>

                    </div>
                </form>
                @else
                @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <!-- <button type="button" class="close" data-dismiss="alert">&times;</button> -->
                    <strong>{{ $message }}</strong>
                </div>
                @endif
                @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-block">
                    <!-- <button type="button" class="close" data-dismiss="alert">&times;</button> -->
                    <strong>{{ $message }} </strong>
                </div>
                @endif
                <form method="POST" action="{{ route('verify') }}">
                    @csrf
                    <div class="form-wrapper text-center">
                        <h2 class="text-center">Verify Code</h2>
                        <div class="row">
                            <div class="col-lg-12 first-name">
                                <label class="justify-content-center align-items-center ">
                                    <span class="material-symbols-outlined">
                                        format_list_numbered
                                    </span>
                                </label>
                                <input type="text" name="code" class="form-control" placeholder="Code" required>
                            </div>
                            <div class="sign-up">
                                <button type="submit">Verify</button>
                            </div>
                        </div>

                    </div>
                </form>
                @endif
            </div>
            <div class="col-lg-5">
                <div class="images text-center ">
                    <img src="{{ asset('front_assets/images/login-form.jpg') }}" alt="" class="img-fluid ">
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
