@extends('front.layout.master')

@section('content')
<section id="section-title-name">
    <div class="container ">
        <div class="title text-center ">
            <h1>Reset Password</h1>
        </div>
    </div>

</section>

<section id="reset-password-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 ">
                <div class="forget-password-wrapper">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <form method="POST" action="{{ route('password.update') }}" id="form_register">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-wrapper">
                            <div class="row">
                                <div class="col-lg-0 email-address">
                                    <h5>Email<span class="text-danger">*</span></h5>
                                    <label class="justify-content-center align-items-center ">
                                        <span class="material-symbols-outlined">
                                            mail
                                        </span>
                                    </label>
                                    <input type="email" id="email" placeholder="Email Address" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-lg-0 email-address">
                                    <h5>Password<span class="text-danger">*</span></h5>
                                    <label class="justify-content-center align-items-center ">
                                        <span class="material-symbols-outlined">
                                        lock
                                        </span>
                                    </label>
                                    <input type="password" id="password" placeholder="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-lg-0 email-address">
                                    <h5>Confirm Password<span class="text-danger">*</span></h5>
                                    <label class="justify-content-center align-items-center ">
                                        <span class="material-symbols-outlined">
                                        lock
                                        </span>
                                    </label>
                                    <input type="password" id="password" name="password_confirmation" placeholder="password_confirmation">
                                </div>

                                <div class="password-btn text-center">
                                    <button type="submit">Reset Password</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-6 my-auto ">
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
