@extends('front.layout.master')

@section('content')

<section id="about-us-banner">
    <div class="container ">
        <div class="section-title text-center ">
            <h1>Hire Cab</h1>
        </div>
    </div>
</section>

<section id="car-insurance-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 my-auto">
                <div class="images">
                    <img src="{{ asset('front_assets/images/hireCab.png') }}" alt="" class="img-fluid" width="400" height="400">
                </div>
            </div>
            <div class="col-lg-6 my-auto">
                <div class="car-insurance-content ">
                    <h3>Road Sathi 24*7 Cab Services</h3>
                    <div class="benefits gap-5">
                        <ul>
                            <li class="gap-2 ">
                                <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                                One-Way Cab Services
                            </li>
                            <li class="gap-2 ">
                                <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                                Out-Station Cab Services
                            </li>
                            <li class="gap-2 ">
                                <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                                Corporate Cab Bookings
                            </li>
                            <li class="gap-2 ">
                                <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                                Event/Wedding Cab Services
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="why-road-sathi-cab-service-section">
    <div class="container">
        <div class="row">
            <div class="section-title text-center ">
                <h1>Why Road Sathi Cab Service?</h1>
            </div>
            <div class="col-lg-6">
                <div class="why-road-sathi-content gap-3">
                    <h3>Reliable Service</h3>
                    <ul>
                        <li class="gap-2 ">
                            <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                            Immediate booking with detailed driver information provided.
                        </li>
                        <li class="gap-2 ">
                            <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                            Punctual and on-time service, ensuring you reach your destination without delay.
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="why-road-sathi-content gap-3">
                    <h3>Transparent Billing</h3>
                    <ul>
                        <li class="gap-2 ">
                            <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                            Our pricing is straightforward and transparent, with no hidden fees.
                        </li>
                        <li class="gap-2 ">
                            <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                            Say goodbye to night charges and extra driver fees.
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="why-road-sathi-content gap-3">
                    <h3>Clean Car</h3>
                    <ul>
                        <li class="gap-2 ">
                            <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                            Your safety is our priority. Our vehicles are thoroughly sanitized after each ride.
                        </li>
                        <li class="gap-2 ">
                            <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                            Experience the freshness of a professionally cleaned car every time you ride with us.
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="why-road-sathi-content gap-3">
                    <h3>Professional Drivers</h3>
                    <ul>
                        <li class="gap-2 ">
                            <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                            Rest assured, our drivers are meticulously verified and extensively trained.
                        </li>
                        <li class="gap-2 ">
                            <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                            Our customer-centric approach ensures a pleasant journey with gentle and well-behaved drivers.
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <div class="why-road-sathi-content gap-3">
                    <h3>24*7 Contact Centre Support</h3>
                    <ul>
                        <li class="gap-2 ">
                            <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                            Need assistance? Our dedicated support team is available around the clock. Call us anytime at 987 987 5066.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="hire-cab-form-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="hire-cab-form-wrapper">
                    <div class="col-lg-12">
                        <form id="hire_frm" method="post" action="{{ route('hire.store', ['hireType' => 'cab']) }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="hireType" value="cab">
                            <div class="form-wrapper">
                                <h1 class="text-center ">Hire Cab</h1>
                                <div class="row">
                                    <div class="col-lg-6 first-name">
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
                                    <div class=" col-lg-6 last-name">
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
                                    <div class="col-lg-6 mobile-number">
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
                                    <div class="col-lg-6 email-wrapper">
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
                                    <div class="col-lg-6 trip-wrapper">
                                        <label class="justify-content-center align-items-center ">
                                            <span>
                                                <img src="{{ asset('front_assets/images/trip.png') }}" alt="" width="24" height="24">
                                            </span>
                                        </label>
                                        <select name="trip_type" id="trip_type" class="form-control @error('trip_type') is-invalid @enderror">
                                            <option value="">Select Trip Type</option>
                                            <option value="One Way Trip">One Way Trip</option>
                                            <option value="Round Trip">Round Trip</option>
                                        </select>
                                        @error('trip_type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 trip-wrapper">
                                        <label class="justify-content-center align-items-center ">
                                            <span class="material-symbols-outlined">
                                                directions_car
                                            </span>
                                        </label>
                                        <select name="type_vehicle" id="type_vehicle" class="form-control @error('type_vehicle') is-invalid @enderror">
                                            <option value="">Select Type of Vehicle</option>
                                            <option value="5 seater">5 Seater</option>
                                            <option value="7 Seater">7 Seater</option>
                                        </select>
                                        @error('type_vehicle')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 email-wrapper">
                                        <label class="justify-content-center align-items-center ">
                                            <span class="material-symbols-outlined">
                                                location_on
                                            </span>
                                        </label>
                                        <input type="text" name="pickup_city" class="form-control @error('pickup_city') is-invalid @enderror" placeholder="PickUp City">
                                        @error('pickup_city')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 email-wrapper">
                                        <label class="justify-content-center align-items-center ">
                                            <span class="material-symbols-outlined">
                                                location_on
                                            </span>
                                        </label>
                                        <input type="text" name="dest_city" class="form-control @error('dest_city') is-invalid @enderror" placeholder="Destination City">
                                        @error('dest_city')
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
                </div>
            </div>
            <div class="col-lg-6">
                <div class="section-title text-center ">
                    <h1>Popular One-way Trips</h1>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="popular-one-way-trips-content gap-3">
                            <img src="{{ asset('front_assets/images/taxi.png')}}" alt="" width="36">
                            <h3>Ahmedabad to Vadodara</h3>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="popular-one-way-trips-content gap-3">
                            <img src="{{ asset('front_assets/images/taxi.png')}}" alt="" width="36">
                            <h3>Ahmedabad to Surat</h3>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="popular-one-way-trips-content gap-3">
                            <img src="{{ asset('front_assets/images/taxi.png')}}" alt="" width="36">
                            <h3>Ahmedabad to Mumbai</h3>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="popular-one-way-trips-content gap-3">
                            <img src="{{ asset('front_assets/images/taxi.png')}}" alt="" width="36">
                            <h3>Ahmedabad to Rajkot</h3>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="popular-one-way-trips-content gap-3">
                            <img src="{{ asset('front_assets/images/taxi.png')}}" alt="" width="36">
                            <h3>Vadodara to Mumbai</h3>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="popular-one-way-trips-content gap-3">
                            <img src="{{ asset('front_assets/images/taxi.png')}}" alt="" width="36">
                            <h3>Vadodara to Ahmedabad</h3>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="popular-one-way-trips-content gap-3">
                            <img src="{{ asset('front_assets/images/taxi.png')}}" alt="" width="36">
                            <h3>Surat to Mumbai</h3>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="popular-one-way-trips-content gap-3">
                            <img src="{{ asset('front_assets/images/taxi.png')}}" alt="" width="36">
                            <h3>Rajkot to Ahmedabad</h3>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="popular-one-way-trips-content gap-3">
                            <img src="{{ asset('front_assets/images/taxi.png')}}" alt="" width="36">
                            <h3>Mumbai to Ahmedabad</h3>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="popular-one-way-trips-content gap-3">
                            <img src="{{ asset('front_assets/images/taxi.png')}}" alt="" width="36">
                            <h3>Surat to Ahmedabad</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if ($message = Session::get('success'))
<div class="modal fade show" id="thankyouModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Hire Cab</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
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
                <button type="button" class="btn btn-secondary call-btn" data-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
@endif

@endsection
@section('scripts')
<!-- <script>
    window.addEventListener('load', function() {
        loadJS("{{ asset('front_assets/js/jquery.validate.min.js') }}");
        loadJS("{{ asset('front_assets/custom_js/hire_car_bus.js') }}");
    });
</script> -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" defer></script>
<script src="{{ asset('front_assets/js/jquery.validate.min.js') }}" defer></script>
<script src="{{ asset('front_assets/custom_js/hire_car_bus.js') }}" defer></script>
@endsection
