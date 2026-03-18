@extends('front.layout.master')

@section('content')

<section id="about-us-banner">
    <div class="container ">
        <div class="section-title text-center ">
            <h1>Hire Bus</h1>
        </div>
    </div>
</section>

<section id="road-sathi-bus-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 my-auto">
                <div class="images text-center">
                    <img src="{{ asset('front_assets/images/hireBus.png') }}" alt="" class="img-fluid" width="400" height="400">
                </div>
            </div>
            <div class="col-lg-6 ">
                <div class="road-sathi-bus-services">
                    <h3>Road Sathi 24*7 Bus Services</h3>
                    <p>Hire a Bus in Ahmedabad is only one click away. Road Sathi provides all types of bus booking services for Family trips, Group Tours, Event tours, School tours, Corporate tours and Marriage trips will all types of below-mentioned options. </p>
                    <div class="benefits gap-5">
                        <ul>
                            <li class="gap-2 ">
                                <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                                Hire a Tempo Travellers
                            </li>
                            <li class="gap-2 ">
                                <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                                Hire a Mini Bus (20,29,36 Seater)
                            </li>
                            <li class="gap-2 ">
                                <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                                Hire a Luxury AC Bus (41, 45, 49 Seater)
                            </li>
                            <li class="gap-2 ">
                                <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                                Hire a Volvo
                            </li>
                        </ul>
                    </div>
                    <p>Road Sathi also Provides different two types of Packages </p>
                    <div class="benefits gap-5">
                        <ul>
                            <li class="gap-2 ">
                                <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                                Full Day 300 Km.
                            </li>
                            <li class="gap-2 ">
                                <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                                8 hours 80 Km.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="why-road-sathi-bus-service-section">
    <div class="container">
        <div class="row">
            <div class="section-title text-center ">
                <h1>Why Road Sathi Bus Service?</h1>
            </div>
            <div class="col-lg-6">
                <div class="why-road-sathi-content gap-3">
                    <h3>Easy & Reliable Service </h3>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="why-road-sathi-content gap-3">
                    <h3>Transparent Billing </h3>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="why-road-sathi-content gap-3">
                    <h3>24*7 Contact Centre Support anytime at 987 987 5066 </h3>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="why-road-sathi-content gap-3">
                    <h3>Clean & Clear Buses </h3>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="why-road-sathi-content gap-3">
                    <h3>Professional Drivers </h3>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="why-road-sathi-content gap-3">
                    <h3>First Aid available </h3>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="terms-of-service-bus-section">
    <div class="container">
        <div class="section-title text-center ">
            <h1>Terms Of Service for Bus on Rent in Ahmedabad </h1>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="benefits gap-5">
                    <ul>
                        <li class="gap-2 ">
                            <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                            Parking, Toll Tax, Border Tax, State Permit Will Be Charged Extra On Actual.
                        </li>
                        <li class="gap-2 ">
                            <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                            Driver Allowance Per Day – 200/- Extra, Night Charge Per Night – 100/- Extra.
                        </li>
                        <li class="gap-2 ">
                            <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                            The Hours & KMS Are Computed From Our Ahmedabad Office To Ahmedabad Office.
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="benefits gap-5">
                    <ul>
                        <li class="gap-2 ">
                            <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                            Tariff Will Be Changed As Per Fuel Rate Hike.
                        </li>
                        <li class="gap-2 ">
                            <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                            All the Above Rates May Be Differ During Season / Weekend.
                        </li>
                        <li class="gap-2 ">
                            <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                            In Case Of Cancellation Of Duty, Minimum 8hrs/80kms Will be Charged.
                        </li>
                        <li class="gap-2 ">
                            <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                            GST Extra As Applicable
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="hire-bus-form-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="hire-bus-form-wrapper">
                    <div class="col-lg-12">
                        <form id="hire_frm" method="post" action="{{ route('hire.store', ['hireType' => 'bus']) }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="hireType" value="bus">
                            <div class="form-wrapper">
                                <h1 class="text-center ">Hire bus</h1>
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
                                        <select name="trip_type" id="trip_type" class="form-control">
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
                                                directions_bus
                                            </span>
                                        </label>
                                        <select name="type_vehicle" id="type_vehicle" class="form-control">
                                            <option value="">Select Type of Vehicle</option>
                                            <option value="20 Seater">20 Seater</option>
                                            <option value="30 Seater">30 Seater</option>
                                            <option value="40 Seater">40 Seater</option>
                                            <option value="50 Seater">50 Seater</option>
                                            <option value="45 Seater">45 Seater</option>
                                            <option value="56 Seater">56 Seater</option>
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
                            <img src="{{ asset('front_assets/images/bus.png')}}" alt="" width="36">
                            <h3>Ahmedabad to Vadodara</h3>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="popular-one-way-trips-content gap-3">
                            <img src="{{ asset('front_assets/images/bus.png')}}" alt="" width="36">
                            <h3>Ahmedabad to Surat</h3>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="popular-one-way-trips-content gap-3">
                            <img src="{{ asset('front_assets/images/bus.png')}}" alt="" width="36">
                            <h3>Ahmedabad to Mumbai</h3>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="popular-one-way-trips-content gap-3">
                            <img src="{{ asset('front_assets/images/bus.png')}}" alt="" width="36">
                            <h3>Ahmedabad to Rajkot</h3>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="popular-one-way-trips-content gap-3">
                            <img src="{{ asset('front_assets/images/bus.png')}}" alt="" width="36">
                            <h3>Vadodara to Mumbai</h3>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="popular-one-way-trips-content gap-3">
                            <img src="{{ asset('front_assets/images/bus.png')}}" alt="" width="36">
                            <h3>Vadodara to Ahmedabad</h3>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="popular-one-way-trips-content gap-3">
                            <img src="{{ asset('front_assets/images/bus.png')}}" alt="" width="36">
                            <h3>Surat to Mumbai</h3>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="popular-one-way-trips-content gap-3">
                            <img src="{{ asset('front_assets/images/bus.png')}}" alt="" width="36">
                            <h3>Rajkot to Ahmedabad</h3>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="popular-one-way-trips-content gap-3">
                            <img src="{{ asset('front_assets/images/bus.png')}}" alt="" width="36">
                            <h3>Mumbai to Ahmedabad</h3>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="popular-one-way-trips-content gap-3">
                            <img src="{{ asset('front_assets/images/bus.png')}}" alt="" width="36">
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
                <h5 class="modal-title" id="exampleModalLabel">Hire bus</h5>
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
