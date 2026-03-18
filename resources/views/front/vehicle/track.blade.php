<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Road Sathi</title>

    @php
    $svgFile = asset('front_assets/images/favicon.svg');
    $svgContent = file_get_contents($svgFile);
    $base64Encoded = 'data:image/svg+xml;base64,' . base64_encode($svgContent);
    @endphp

    <link rel="shortcut icon" href="{{ $base64Encoded }} " type="image/x-icon">
    <link rel="icon" href="{{ $base64Encoded }}" type="image/x-icon">
    <!-- <link rel="shortcut icon" href="{{ asset('front_assets/images/favicon.ico') }} " type="image/x-icon">
    <link rel="icon" href="{{ asset('front_assets/images/favicon.ico') }}" type="image/x-icon"> -->

    <link rel="stylesheet" href="{{ asset('front_assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('front_assets/css/responsive.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script>
        var site_url = '<?= SITE_URL; ?>';
    </script>
</head>

<body>

    <section id="about-us-banner">
        <div class="container ">
            <div class="section-title text-center ">
                <h1>Vehicle Details</h1>
            </div>
        </div>
    </section>

    <section id="vehicle-track-title">
        <!-- <div class="container">
            <div class="section-title text-center ">
                <h1>Vehicle Details</h1>
            </div>
        </div> -->
    </section>

    <section id="vehicle-track-wrapper">
        <div class="container">
            <div class="row gy-3">
                <div class="col-lg-3 text-center ">
                    <div class="card">
                        <div class="vehicle-card d-flex gap-2">
                            <div class="images">
                                <img src="{{ asset('front_assets/images/r-img.png') }}" alt="">
                            </div>
                            <!-- <div class="owner-name d-flex gap-2">
                                <h5>Name:</h5>
                                <p>Jaivin Patel</p>
                            </div> -->
                            <div class="vehicle-number my-auto ">
                                <!-- <h5>vechicle no:</h5> -->
                                <p>{{ $vehicleData->vehicle_no }}</p>
                                <div class="model-nam">
                                    <!-- <h5>brand:</h5> -->
                                    <p>{{ vehicleBrands($vehicleData->brand) }}  {{ vehicleModel($vehicleData->model) }}</p>
                                </div>
                            </div>
                            <!-- <div class="dot-btn group" role="group">
                            <button type="button" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="material-symbols-outlined">
                                more_vert
                                </span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Edit</a></li>
                                <li><a class="dropdown-item" href="#">Delete</a></li>
                                <li><a class="dropdown-item" href="#">View</a></li>
                            </ul>
                            </div> -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="track-info-wrapper">
                        @foreach (Safety_messages($vehicleData->vehicle_no) as $key=>$Safety_messages)
                        <div class="parcking-btn">
                            <a href="#" data-id="{{ $key }}" class="send_msg" data-vehicle_no="{{ $vehicleData->vehicle_no }}" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">
                                {{ $key }}
                                <span class="material-symbols-outlined">
                                    arrow_right_alt
                                </span>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="track-info-wrapper modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Thank You</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="message-body modal-body d-flex gap-3">
                    <div class="massage">
                        <p></p>
                        <!-- <h4>Thanks Your</h4>
                            <h3>Sent by: Road Sathi</h3> -->
                        <strong>Your Request has been sent to vehicle owner. Thanks</strong>
                    </div>
                </div>
                <!-- <div class="modal-footer">
              <button class="btn btn-primary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">Open second modal</button>
            </div> -->
            </div>
        </div>
    </div>

    <section id="footer" style="padding: 0px;">
        <footer>
            <hr>
            <section id="footer-row" class="">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 ">
                            <div class="right-reservad">
                                <p>@ {{ now()->year }} All right reserved by Kinix Infotech Pvt. Ltd</p>
                            </div>
                        </div>
                        <div class="col-lg-6 text-end ">
                            <div class="terms-wrapper">
                                <a href="{{ url('termscondition') }}">Terms & Conditions</a>
                                |
                                <a href="{{ url('privacypolicy') }}">Privacy Policy</a>
                            </div>
                        </div>
                    </div>
                </div>

            </section>
        </footer>

    </section>

    <script src="{{ asset('front_assets/custom_js/track.js') }}"></script>
</body>

</html>
