@extends('front.layout.master')

@section('content')
<section id="hero-section-slider">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 my-auto ">
                <div class="main-slide">
                    <marquee class="marq" direction="up" loop="" scrollamount="5">
                        <div class="geek1">
                            <p>PARKING PROBLEM</p>
                        </div>
                        <div class="geek1">
                            <p>VEHICLE NOT LOCKED OR OTHER ISSUES</p>
                        </div>
                        <div class="geek1">
                            <p>ACCIDENT INFORMATION</p>
                        </div>
                        <div class="geek1">
                            <p>TOW ALERT</p>
                        </div>
                        <div class="geek1">
                            <p>PERSONAL DETAILS UPDATION AT ACCIDENT</p>
                        </div>
                        <div class="geek1">
                            <p>EMERGENCY FAMILY CONTACT</p>
                        </div>
                    </marquee>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="promo-animate d-md-block d-none">
                    <!-- <img src="{{ asset('front_assets/images/qr-code-back.webp') }}" class="pa__browser" width="211" height="122">
                    <img src="{{ asset('front_assets/images/back-layer.webp') }}" class="pa__map" width="345" height="199">
                    <img src="{{ asset('front_assets/images/mobile-device.webp') }}" class="pa__db" width="336" height="203"> -->
                    <img src="{{ asset('front_assets/images/hero-img.webp') }}" width="218" height="199">
                </div>
                <div class="promo-animate d-md-none">
                    <img src="{{ asset('front_assets/images/hero-img-mobile.webp') }}">
                </div>
            </div>
        </div>
    </div>
</section>

<section id="about-road-sathi-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 my-auto order-2 order-lg-2" data-aos="fade-right" data-aos-duration="1500">
                <video controls poster="{{ asset('front_assets/video/sddefault.jpg')}}"  preload="none">
                    <source type="video/mp4" src="{{ asset('front_assets/video/Road Sathi Safety Tag Self Explanatory Video - For Contact Vehicle Owner.mp4')}}"/>
                </video>
            </div>
            <div class="col-lg-6 order-1 order-lg-2" data-aos="fade-left" data-aos-duration="1500">
                <div class="about-road-sathi-wrapper">
                    <h1 class=""> <span>Road Sathi</span></h1>
                    <div class="benefits gap-5">
                        <ul>
                            <li class="gap-2 ">
                                <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                                Road Safety & Vehicle alert
                            </li>
                            <li class="gap-2 ">
                                <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                                Get Reminder for Renewals
                            </li>
                            <li class="gap-2 ">
                                <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                                Explore, Compare & Buy Insurance
                            </li>
                            <li class="gap-2 ">
                                <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                                Automatic Gate Entry/Exit Facility
                            </li>
                            <li class="gap-2 ">
                                <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                                Get In/Out record
                            </li>
                        </ul>
                        <ul>
                            <li class="gap-2 ">
                                <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                                Allocated Parking Facility
                            </li>
                            <li class="gap-2 ">
                                <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                                Wrong Parking Detection
                            </li>
                            <li class="gap-2 ">
                                <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                                Book a Corporate Parking Slot
                            </li>
                            <li class="gap-2 ">
                                <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                                EV Charging station slot booking
                            </li>
                        </ul>
                    </div>
                    <!-- <div class="read-more-btn">
                        <a href="{{ route('contact') }}">
                            read more
                        </a>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</section>

<section id="services-section">
    <div class="container">
        <div class="section-title text-center ">
            <h1>Services</h1>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="tab">
                    <button class="tablinks" onclick="openCity(event, 'parking')" id="defaultOpen">Wrong Parking Alert</button>
                    <button class="tablinks" onclick="openCity(event, 'notlocked')">Unlocked Vehicle Alert</button>
                    <button class="tablinks" onclick="openCity(event, 'accident')">Headlights On Alert</button>
                    <button class="tablinks" onclick="openCity(event, 'tow')">Tow Alert</button>
                    <button class="tablinks" onclick="openCity(event, 'personal')">Accident Alert</button>
                    <button class="tablinks" onclick="openCity(event, 'emergency')">Emergency Alert</button>
                </div>


                <div id="parking" class="tabcontent">
                    <h3>Wrong Parking Alert</h3>
                    <p>People can send alert to vehicle owner in case of vehicle parked wrongly or in restricted areas
                        to avoid any inconvenience.</p>
                    <div class="images">
                        <img src="{{ asset('front_assets/images/home-services/parking-problem.webp') }}" alt="" class="img-fluid">
                        <img src="{{ asset('front_assets/images/home-services/parking-problem-bike.webp') }}" alt="" class="img-fluid">
                    </div>
                    <!-- <div class="images d-md-none">
                        <img src="{{ asset('front_assets/images/home-services/parking-problem-mobile.webp') }}" alt="" class="img-fluid">
                    </div> -->
                </div>



                <div id="notlocked" class="tabcontent">
                    <h3>Unlocked Vehicle Alert</h3>
                    <p>Vehicle owner may get alert by victim in case of not locked vehicle, light on, fire or theft
                        practise.</p>
                    <div class="images">
                        <img src="{{ asset('front_assets/images/home-services/Unlocked-Vehicle-Alert.webp') }}" alt=""
                            class="img-fluid">
                        <img src="{{ asset('front_assets/images/home-services/Unlocked-bike.webp') }}" alt=""
                            class="img-fluid">
                    </div>
                    <!-- <div class="images d-md-none">
                        <img src="{{ asset('front_assets/images/home-services/Unlocked-Vehicle-Alert-mobile.webp') }}" alt=""
                            class="img-fluid">
                    </div> -->
                </div>

                <div id="accident" class="tabcontent">
                    <h3>Headlights On Alert</h3>
                    <p>In case of accident, family member get informed by victim to take immediate action.</p>
                    <div class="images">
                        <img src="{{ asset('front_assets/images/home-services/headlight-on-alert.webp') }}" alt=""
                            class="img-fluid">
                        <img src="{{ asset('front_assets/images/home-services/headlight-on-alert-bike.webp') }}" alt=""
                            class="img-fluid">
                    </div>
                    <!-- <div class="images d-md-none">
                        <img src="{{ asset('front_assets/images/home-services/headlight-on-alert-mobile.webp') }}" alt=""
                            class="img-fluid">
                    </div> -->
                </div>

                <div id="tow" class="tabcontent">
                    <h3>Tow Alert</h3>
                    <p>Department person can send a alert that your vehicle has been tow due to park in restricted area
                    </p>
                    <div class="images">
                        <img src="{{ asset('front_assets/images/home-services/TOW-ALERT.webp') }}" alt="" class="img-fluid">
                        <img src="{{ asset('front_assets/images/home-services/TOW-ALERT-bike.webp') }}" alt="" class="img-fluid">
                    </div>
                    <!-- <div class="images d-md-none">
                        <img src="{{ asset('front_assets/images/home-services/TOW-ALERT-mobile.webp') }}" alt="" class="img-fluid">
                    </div> -->
                </div>
                <div id="personal" class="tabcontent">
                    <h3>Accident Alert</h3>
                    <p>Helper can get personal details like blood group, health issue etc to provide medical treatment
                        in accidental cases.</p>
                    <div class="images">
                        <img src="{{ asset('front_assets/images/home-services/PERSONAL-DETAILS-UPDATION-AT-ACCIDENT.webp') }}" alt=""
                            class="img-fluid">
                        <img src="{{ asset('front_assets/images/home-services/PERSONAL-DETAILS-UPDATION-AT-ACCIDENT-bike.webp') }}" alt=""
                            class="img-fluid">
                    </div>
                    <!-- <div class="images d-md-none">
                        <img src="{{ asset('front_assets/images/home-services/PERSONAL-DETAILS-UPDATION-AT-ACCIDENT-mobile.webp') }}" alt=""
                            class="img-fluid">
                    </div> -->
                </div>
                <div id="emergency" class="tabcontent">
                    <h3>Emergency Alert</h3>
                    <p>In case of an accident, victim can contact the driver's family through our platform and our
                        system protects contact’s privacy.</p>
                    <div class="images d-md-block d-none">
                        <img src="{{ asset('front_assets/images/home-services/EMERGENCY-FAMILY-CONTACT.webp') }}" alt=""
                            class="img-fluid">
                    </div>
                    <div class="images d-md-none">
                        <img src="{{ asset('front_assets/images/home-services/EMERGENCY-FAMILY-CONTACT-mobile.webp') }}" alt=""
                            class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="why-choose-us-section">
    <div class="container">
        <div class="section-title text-center ">
            <h1>why choose us</h1>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="why-choose-us-content gap-3">
                    <div class="icon  ">
                        <img src="{{ asset('front_assets/images/why-choose-us-icon.svg') }}" alt="" width="50" height="50">
                    </div>
                    <div class="content-wrapper">
                        <h3>Stay Connected with Vehicle 24X7</h3>
                        <p>Anyone can notified you about your vehicle required your attention in any situation, any
                            where any time.</p>
                    </div>
                </div>
                <div class="why-choose-us-content gap-3">
                    <div class="icon  ">
                        <img src="{{ asset('front_assets/images/why-choose-us-icon.svg') }}" alt="" width="50" height="50">
                    </div>
                    <div class="content-wrapper">
                        <h3>Emergency Connect with Family</h3>
                        <p>In case of Emergency situation like Accidental, Any people can connect with Road Sathi
                            customer care and Road Sathi will infirmed to your emergency contact number</p>
                    </div>
                </div>
                <div class="why-choose-us-content gap-3">
                    <div class="icon  ">
                        <img src="{{ asset('front_assets/images/why-choose-us-icon.svg') }}" alt="" width="50" height="50">
                    </div>
                    <div class="content-wrapper">
                        <h3>Whose Vehicle?</h3>
                        <p>Receive real-time updates on your vehicle through Road Sathi without compromising your
                            personal details or identity.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="why-choose-us-content gap-3">
                    <div class="icon  ">
                        <img src="{{ asset('front_assets/images/why-choose-us-icon.svg') }}" alt="" width="50" height="50">
                    </div>
                    <div class="content-wrapper">
                        <h3>RS Safety Tag</h3>
                        <p>A vehicle identity tag, indicating that the owner can be reached anytime via phone.</p>
                    </div>
                </div>
                <div class="why-choose-us-content gap-3">
                    <div class="icon  ">
                        <img src="{{ asset('front_assets/images/why-choose-us-icon.svg') }}" alt="" width="50" height="50">
                    </div>
                    <div class="content-wrapper">
                        <h3>Docs Storage & Reminders</h3>
                        <p>Store your imp. vehicle docs and also get timely reminders for Emission, Insurance, and other
                            essential vehicle documents renewals.</p>
                    </div>
                </div>
                <div class="why-choose-us-content gap-3">
                    <div class="icon  ">
                        <img src="{{ asset('front_assets/images/why-choose-us-icon.svg') }}" alt="" width="50" height="50">
                    </div>
                    <div class="content-wrapper">
                        <h3>One-Stop Insurance Hub</h3>
                        <p>Explore, compare, and purchase a variety of General and Life insurance quotes from Desire
                            Company's comprehensive offerings.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>


<section id="testimonials-slider">
    <div class="container">
        <div class="row">
            <div class="section-title text-center ">
                <h1>Testimonials
                </h1>
            </div>
            <div id="testimonials-slider-wrapper" class="testmonials-slider-box">
                <div class="review-content ">
                    <div class="d-flex gap-0">
                        <div class="images">
                            <!-- <img src="{{ asset('front_assets/images/testimonials-img-1.png') }}" alt="" class="img-fluid"> -->
                        </div>
                        <p>Great initiative. "RS Safety Tag" is a must-have in every vehicle. Easy setup, real-time
                            alerts, and peace of mind on the road. Highly recommend! </p>
                    </div>

                    <div class="title">
                        <h5>Ashish Dave</h5>
                        <h6>Ahmedabad</h6>
                    </div>
                </div>
                <div class="review-content ">
                    <div class="d-flex gap-0">
                        <div class="images">
                            <!-- <img src="{{ asset('front_assets/images/testimonials-img-1.png') }}" alt="" class="img-fluid"> -->
                        </div>
                        <p>Five stars for the Road Safety Tag! Compact, reliable, and the collision detection is a
                            game-changer. A big impact on safety!</p>
                    </div>

                    <div class="title">
                        <h5>Jainam Belani</h5>
                        <h6>Ahmedabad</h6>
                    </div>
                </div>
                <div class="review-content ">
                    <div class="d-flex gap-0">
                        <div class="images">
                            <!-- <img src="{{ asset('front_assets/images/testimonials-img-1.png') }}" alt="" class="img-fluid"> -->
                        </div>
                        <p>Peace of Mind! Instant alerts about wrong parking, taw information and accident information.
                            Love
                            it!</p>
                    </div>

                    <div class="title">
                        <h5>Jaivin Seladiya</h5>
                        <h6>BusinessMan, Ahmedabad</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="{{ asset('front_assets/js/aos.js') }}" defer></script>
<script src="{{ asset('front_assets/js/client-jquery-2.2.0.min.js') }}" defer></script>
<script src="{{ asset('front_assets/js/client-slick.js') }}" defer></script>
<script src="{{ asset('front_assets/custom_js/home.js') }}" defer></script>
@endsection
