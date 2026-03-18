@extends('front.layout.master')

@section('content')

<section id="request-call-back-form">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
            <div class="request-call-back-form-wrapper">
                <div class="col-lg-6">
                <form id="insurance_qut_frm" method="post" action="{{ route('add.ins.enquiry') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="name" value="{{ $name }}">
                    <div class="form-wrapper">
                        <h2 class="text-center ">Request a Call Back form</h2>
                        <p class="text-center ">{{ ucwords($name) }}</p>
                        <div class="row">
                            <div class="col-lg-12 first-name">
                                <label class="justify-content-center align-items-center ">
                                    <span class="material-symbols-outlined">
                                        person
                                    </span>
                                </label>
                                <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" placeholder="First Name">
                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class=" col-lg-12 last-name">
                                <label class="justify-content-center align-items-center ">
                                    <span class="material-symbols-outlined">
                                        person
                                    </span>
                                </label>
                                <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" placeholder="Last Name">
                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-lg-12 mobile-number">
                                <label class="justify-content-center align-items-center ">
                                    <span class="material-symbols-outlined">
                                        phone_iphone
                                    </span>
                                </label>
                                <input type="number" name="mobile_number" class="form-control @error('mobile_number') is-invalid @enderror" placeholder="Mobile Number">
                                @error('mobile_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-lg-12 email-wrapper">
                                <label class="justify-content-center align-items-center ">
                                    <span class="material-symbols-outlined">
                                        mail
                                    </span>
                                </label>
                                <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- <div class="col-lg-12 policy-document">
                                <input type="file" name="image" class="@error('image') is-invalid @enderror" accept="image/*">
                            </div> -->
                            <div class="col-lg-12 massage-box">
                                <textarea name="message" class="form-control @error('message') is-invalid @enderror" placeholder="Message" id="" cols="10" rows="4"></textarea>
                                @error('message')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="sign-up text-center ">
                                <button type="submit"> Submit </button>
                                <!-- <a href="#"></a> -->
                            </div>
                        </div>

                    </div>
                </form>
                </div>
                <div class="col-lg-6 my-auto ">
                <div class="images">
                    <img src="{{ asset('front_assets/images/login-form.jpg') }}" alt="" class="img-fluid ">
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
        loadJS("{{ asset('front_assets/custom_js/store.js') }}");
    });
</script>
@endsection
