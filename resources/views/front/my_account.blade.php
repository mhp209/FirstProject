@extends('front.layout.master')

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
@endsection


@section('content')

<section id="my-account-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @include('front.layout.my_account_navbar')
            </div>
            <div class="col-lg-12 d-flex gap-3 ">
                <div class="user-datelis-wrapper">
                <div class="col-lg-6 ">
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <!-- <button type="button" class="close" data-bs-dismiss="alert">&times;</button> -->
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif
                    @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-block">
                        <!-- <button type="button" class="close" data-bs-dismiss="alert"><i class="fs-6 far fa-times-circle"></i></button> -->
                        <strong>{{ $message }} </strong>
                    </div>
                    @endif
                    <form method="POST" action="{{ route('user.update') }}" id="form_register"
                        enctype="multipart/form-data">
                        @csrf
                        <div class=" form-wrapper">
                            <h2 class="text-center">user profile</h2>
                            <div class="row gy-3">
                                <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                                <div class="first-name-wrapper gap-2">
                                    <div class="col-lg-12 user-name">
                                        <h5>First name</h5>
                                        <label class="justify-content-center align-items-center ">
                                            <span class="material-symbols-outlined">
                                                person
                                            </span>
                                        </label>
                                        <input type="text" placeholder="First Name" name="first_name" id="first_name"
                                            class="@error('first_name') is-invalid @enderror"
                                            value="{{ Auth::user()->first_name }}">
                                        @error('first_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-12 user-name">
                                        <h5>Last name</h5>
                                        <label class="justify-content-center align-items-center ">
                                            <span class="material-symbols-outlined">
                                                person
                                            </span>
                                        </label>
                                        <input type="text" placeholder="Last Name" name="last_name"
                                            class="from-control @error('last_name') is-invalid @enderror"
                                            value="{{ Auth::user()->last_name }}">
                                        @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-12 email-wrapper">
                                        <h5>Email</h5>
                                        <label class="justify-content-center align-items-center ">
                                            <span class="material-symbols-outlined">
                                                mail
                                            </span>
                                        </label>
                                        <input type="text" placeholder="Email" name="email"
                                            class="@error('email') is-invalid @enderror"
                                            value="{{ Auth::user()->email }}">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-12 mobile-number">
                                        <h5>Blood Group</h5>
                                        <select class="form-control @error('blood_group') is-invalid @enderror"
                                            name="blood_group">
                                            <option value="">Select Blood group</option>
                                            <option value="A+" {{(Auth::user()->blood_group === 'A+') ? 'Selected' :
                                                ''}}>A+</option>
                                            <option value="A-" {{(Auth::user()->blood_group === 'A-') ? 'Selected' :
                                                ''}}>A-</option>
                                            <option value="B+" {{(Auth::user()->blood_group === 'B+') ? 'Selected' :
                                                ''}}>B+</option>
                                            <option value="B-" {{(Auth::user()->blood_group === 'B-') ? 'Selected' :
                                                ''}}>B-</option>
                                            <option value="AB+" {{(Auth::user()->blood_group === 'AB+') ? 'Selected'
                                                : ''}}>AB+</option>
                                            <option value="AB-" {{(Auth::user()->blood_group === 'AB-') ? 'Selected'
                                                : ''}}>AB-</option>
                                            <option value="O+" {{(Auth::user()->blood_group === 'O+') ? 'Selected' :
                                                ''}}>O+</option>
                                            <option value="O-" {{(Auth::user()->blood_group === 'O-') ? 'Selected' :
                                                ''}}>O-</option>
                                        </select>
                                        @error('blood_group')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="edit-profile text-center">
                                    <button type="submit"> Edit profile </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-6 my-auto">
                    <div class="images">
                        <img src="{{ asset('front_assets/images/login-form.jpg') }}" alt="" class="img-fluid">
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
        loadJS("{{ asset('front_assets/custom_js/register.js') }}");
    });
</script>
@endsection
