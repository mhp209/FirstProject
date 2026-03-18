@extends('front.layout.master')

@section('css')
<link rel="stylesheet" href="{{ asset('front_assets/css/aos.css') }}">
@endsection

@section('content')

<section id="about-us-banner">
    <div class="container ">
        <div class="section-title text-center ">
            <h1>about us</h1>
        </div>
</section>

<section id="about-us-section">

    <div class="container">
        <p>Road Sathi is a proud initiative of Kinix Infotech Pvt. Ltd., headquartered in Ahmedabad, Gujarat. Dedicated
            to promoting road safety and convenience, Road Sathi serves as a unique platform that enables users to send
            pertinent vehicle-related alerts to owners. These notifications encompass events such as the vehicle being
            unlocked, incorrect parking, or the creation of unavoidable situations near the vehicle.</p>
        <p>Our mission at Road Sathi is to elevate road safety standards, foster seamless communication, and offer
            innovative automotive services through our dynamic platform. By cultivating a harmonious environment on the
            road, we aim to establish meaningful connections between vehicles and their owners.</p>
        <p>Powered by cutting-edge technology, Road Sathi empowers users to stay well-informed and take swift actions in
            various scenarios, all while maintaining the confidentiality of the vehicle owner's personal details. We are
            committed to providing a secure and efficient avenue for enhancing road safety and communication in the
            automotive landscape.</p>
        </p>
    </div>
    <div class="container">
        <!-- <div class="section-title text-center ">
                <h1>about us</h1>
            </div> -->

        <div class="row">
            <div class="col-lg-6 my-auto ">
                <div class="images">
                    <img src="{{ asset('front_assets\images\img-1.webp') }}" alt="" class="pa-img">
                    <img src="{{ asset('front_assets\images\scan-qr-code.webp') }}" alt="" class="pb">
                    <img src="{{ asset('front_assets\images\access-info.webp') }}" alt="" class="pb-images">
                    <img src="{{ asset('front_assets\images\use-info.webp') }}" alt="" class="pb-img-1">
                </div>
            </div>
            <!-- <div class="col-lg-6" data-aos="fade-right" data-aos-duration="1000">
                <div class="iamges">
                    <img src="{{ asset('front_assets/images/home-about-us.png') }}" alt="" class="img-fluid ">
                </div>
            </div> -->
            <div class="col-lg-6" data-aos="fade-left" data-aos-duration="1000">
                <div class="about-us-wrapper">
                    <div class="about-content-title d-none">
                        <h3>WE ARE IN A MISSION TO HELP YOU GET ROAD SATHI</h3>
                    </div>
                    <div class="para p-0">
                        <h5>Core Values:</h5>
                    </div>
                    <div class="benefits gap-5">
                        <ul>
                            <li class="gap-2 ">
                                <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                                <p>Safety First: Prioritizing the safety and well-being of our users in all our endeavors.</p>
                            </li>
                            <li class="gap-2 ">
                                <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                                <p> Innovation: Constantly pushing boundaries to introduce cutting-edge solutions that
                                redefine road safety.</p>
                            </li>
                            <li class="gap-2 ">
                                <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                                <p>Customer-Centric: Putting our users at the Centre of everything we do, ensuring their
                                needs are met with our excellence.</p>
                            </li>
                            <li class="gap-2 ">
                                <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                                <p>Integrity: Upholding the highest standards of ethics and transparency in all aspects of
                                our operations.</p>
                            </li>
                            <li class="gap-2 ">
                                <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                                <p>Community Building: Fostering a sense of community among Road Sathi users, creating a
                                network that cares for each other's safety and well-being.</p>
                            </li>
                            <li class="gap-2 ">
                                <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                                <p>Sustainability: Striving for eco-friendly practices and contributing to a sustainable
                                future in the automotive industry.</p>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="vision-mission-section">
    <div class="container">
        <div class="row gy-3">
            <div class="col-lg-12">
                <div class="section-title text-center">
                    <h1>Our Vision</h1>
                </div>
                <div class="vision-wrapper gap-3" data-aos="zoom-in-up" data-aos-duration="1000">
                    <div class="images">
                        <img src="{{ asset('front_assets/images/our-vision.png') }}" alt="" class="">
                    </div>
                    <div class="para">
                        <p>At Road Sathi, we envision a safer and more connected road ecosystem, where individuals can
                            travel with confidence, knowing that help is just a scan away. Our vision is to leverage
                            technology to create a seamless network that fosters swift communication between vehicle
                            owners and concerned family members during emergencies. We aspire to be the trusted guardian
                            of road safety, providing innovative solutions that empower people to navigate their
                            journeys securely.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="section-title text-center">
                    <h1>Our Mission</h1>
                </div>
                <div class="vision-wrapper gap-3" data-aos="zoom-in-up" data-aos-duration="1500">
                    <div class="images">
                        <img src="{{ asset('front_assets/images/our-mission.png') }}" alt="" class="">
                    </div>
                    <div class="para">
                        <p>Our mission at Kinix Infotech Pvt. Ltd., the proud creator of Road Sathi, is to revolutionize
                            road safety and connectivity. We are committed to facilitating instant communication between
                            users through our RS Safety tags and dedicated customer helpline. We aim to offer a platform
                            that not only ensures the safety of our members but also simplifies their vehicle-related
                            tasks, including insurance renewals, managing residential parking, controlling access to
                            offices and business centers, or facilitating an organized parking system, etc. As we
                            progress into the next phase, we strive to enhance the overall driving experience by
                            providing a one-stop solution for all types of vehicle-related requirements.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="our-promise-section">
    <div class="container">
        <div class="section-title text-center ">
            <h1>Our Key Services</h1>
        </div>
        <div class="row gy-3">
            <div class="col-lg-12">
                <div class="quick-vehicle-updates-wrapper" data-aos="zoom-in-up" data-aos-duration="1000">
                    <div class="images">
                        <img src="{{ asset('front_assets/images/Quick-Vehicle-Updates.png') }}" alt=""
                            class="img-fluid ">
                    </div>
                    <div class="title">
                        <h3>Integrating RS Safety Tag</h3>
                    </div>
                    <div class="para">
                        <p>A pivotal element ensuring the safety of both vehicles and their owners, the RS Safety Tag
                            plays a crucial role in keeping vehicle owners and their family members informed about
                            unforeseen road and parking incidents. This revolutionary safety tag transforms safety
                            measures with its versatility, serving as an innovative solution for various purposes.
                            Whether it's overseeing residential parking, regulating access to offices and business
                            centers, or streamlining parking systems, the RS Safety Tag stands as the ultimate device
                            for these diverse applications.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-12" >
                <div class="quick-vehicle-updates-wrapper" data-aos="zoom-in-up" data-aos-duration="1500">
                    <div class="images">
                        <img src="{{ asset('front_assets/images/Quick-Vehicle-Updates.png') }}" alt=""
                            class="img-fluid ">
                    </div>
                    <div class="title">
                        <h3>Dedicated Customer Care No</h3>
                    </div>
                    <div class="para">
                        <p>Your safety is paramount to us. At Road Sathi, we prioritize your well-being by providing a
                            dedicated customer care helpline number. This ensures that anyone can swiftly send
                            vehicle-related alerts to the respective vehicle owner. In case of an unfortunate accident
                            or emergency situation, individuals can call Road Sathi's emergency number, where they can
                            provide incident details. Road Sathi acts promptly by relaying this crucial information to
                            the vehicle owner's emergency contact number or family members within a matter of minutes.
                            Our commitment is to ensure rapid response and assistance in times of need, reinforcing the
                            foundation of your safety on the road.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="quick-vehicle-updates-wrapper" data-aos="zoom-in-up" data-aos-duration="2000">
                    <div class="images">
                        <img src="{{ asset('front_assets/images/Quick-Vehicle-Updates.png') }}" alt=""
                            class="img-fluid ">
                    </div>
                    <div class="title">
                        <h3>Insurance Renewal Alerts & Purchase</h3>
                    </div>
                    <div class="para">
                        <p>Seamlessly manage your insurance commitments with our efficient renewal alert system. Stay
                            informed through timely notifications, guaranteeing that you never overlook a renewal
                            deadline, and ensuring your coverage is consistently up-to-date. At Road Sathi, individuals
                            have the convenience of obtaining the best insurance quotes and purchasing optimal policies.
                            Our personalized services extend to offering roadside assistance, identifying nearby
                            garages, facilitating the accidental claim process, and providing comprehensive assistance
                            to our valued customers. With Road Sathi, experience a one-stop solution that not only keeps
                            you updated on insurance matters but also offers tailored services to enhance your overall
                            driving experience.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="our-promise-section">
    <div class="container">
        <div class="section-title text-center">
            <p>At Road Sathi, we are committed to enhancing every step of your journey. Join us in embracing the future
                of travel services, where safety, convenience, and innovation converge. Travel with Road Sathi – Where
                Your Journey Matters!s</p>
        </div>
    </div>
</section>

<section id="cta-section">
    <div class="container ">
        <div class="content text-center">
            <h1>The Best Roadside Assistance Services</h1>
        </div>
        <div class="contact-us-button text-center">
            <a href="{{ route('contact') }}">Contact us</a>
        </div>
    </div>
</section>
@endsection


@section('scripts')
    <script src="{{ asset('front_assets/js/aos.js') }}"></script>
<script>
    AOS.init({
        disable: function () {
            var maxwidth = 800;
            var isMobile = /Mobi|Android/i.test(navigator.userAgent);
            return window.innerWidth < maxwidth || isMobile;
        },
    });
</script>
@endsection
