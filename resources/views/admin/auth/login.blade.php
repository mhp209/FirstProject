@extends('admin.layouts.auth')

@section('content')
<div class="account-wrapper">
    <h3 class="account-title">Login</h3>
    <p class="account-subtitle">Access to our dashboard</p>
    
    <!-- <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-bs-dismiss="alert">×</button>
        <strong>TEST</strong>
    </div>
 -->
    @if ($message = Session::get('error'))
    <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-bs-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
    @endif    
    
    <!-- Account Form -->
    <form method="POST" action="{{ route('admin.login') }}" id="frmlogin">
        @csrf
        <div class="form-group">
            <label for="emailaddress" class="form-label">{{ __('Email Address') }}</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="Enter your email" autofocus>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="password" class="form-label">{{ __('Password') }}</label>
            <div class="input-group input-group-merge">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Enter your password" autocomplete="current-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group text-center">
            <button class="btn btn-primary account-btn" type="submit">{{ __('Login') }}</button>
        </div>
    </form>
    <!-- /Account Form -->
</div>
@endsection
