@extends('front.layout.master')

@section('content')

<section id="my-vechicle-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @include('front.layout.my_account_navbar')
            </div>
            <div class="col-lg-12">
                <div class="user-datelis-wrapper">
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
                    <div class="col-lg-12">
                    <div class="edit-profile">
                                <a href="{{ route('add.vehicle') }}">Link Vechicle</a>
                            </div>
                    </div>
                    <div class="row gy-2 gap-3">
                        @if(count($vehicle_list) > 0)
                        @foreach ($vehicle_list as $key=>$vehicle)
                        <div class="card col-lg-3">
                            <div class="vechicle-card d-flex">
                                <div class="images">
                                    <img src="{{ asset('front_assets/images/r-img.png') }}" alt="">

                                </div>
                                <div class="vehicle-number my-auto ">
                                    <!-- <h5>vechicle no:</h5> -->
                                    <p>{{ $vehicle->vehicle_no }}</p>
                                    <div class="model-nam">
                                        <!-- <h5>brand:</h5> -->
                                        <p>{{ vehicleBrands($vehicle->brand) }} {{ vehicleModel($vehicle->model) }} </p>
                                    </div>
                                </div>
                                <div class="dot-btn group" role="group">
                                    <button type="button" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="material-symbols-outlined">
                                            more_vert
                                        </span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('edit.vehicle', Crypt::encrypt($vehicle->id) ) }}">Edit</a></li>
                                        <li><a class="dropdown-item delete" href="javascript:;" data-toggle="tooltip" data-id="{{ $vehicle->id }}" data-href="{{ url('del-vehicle/'. $vehicle->id) }}">Delete</a></li>
                                        <li><a class="dropdown-item" href="{{ route('info.vehicle', Crypt::encrypt($vehicle->id) )}}">View</a></li>
                                    </ul>
                                </div>


                            </div>
                        </div>
                        @endforeach
                        @else
                        <p class="text-center mt-5 mb-0">No Vehicle Added</p>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<div class="view-details-pop modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Honda City</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="link-vehicle-datelis-wrapper">
                    <form action="">
                        <div class="form-wrapper">
                            <div class="row">
                                <div class="col-lg-0 owner-name">
                                    <h5>owner name<span class="text-danger">*</span></h5>
                                    <label class="justify-content-center align-items-center ">
                                        <span class="material-symbols-outlined">
                                            person
                                        </span>
                                    </label>
                                    <input type="text" placeholder="Enter Your Owner Nmae">
                                </div>
                                <div class="col-lg-0 vechicle-number">
                                    <h5>vehicle no<span class="text-danger">*</span></h5>
                                    <label class="justify-content-center align-items-center ">
                                        <span class="material-symbols-outlined">
                                            format_list_numbered
                                        </span>
                                    </label>
                                    <input type="number" placeholder="Enter your vechicle Number">
                                </div>
                                <div class="col-lg-0 license-number">
                                    <h5>license no<span class="text-danger">*</span></h5>
                                    <label class="justify-content-center align-items-center ">
                                        <span class="material-symbols-outlined">
                                            badge
                                        </span>
                                    </label>
                                    <input type="number" placeholder="Enter Your Vehicle License No">
                                </div>
                                <div class="col-lg-0 rc-number">
                                    <h5>RC no<span class="text-danger">*</span></h5>
                                    <label class="justify-content-center align-items-center ">
                                        <span class="material-symbols-outlined">
                                            call
                                        </span>
                                    </label>
                                    <input type="number" placeholder="Enter Your Vehicle RC No">
                                </div>
                                <div class="col-lg-0 mobile-number">
                                    <h5>mobile no<span class="text-danger">*</span></h5>
                                    <label class="justify-content-center align-items-center ">
                                        <span class="material-symbols-outlined">
                                            phone_iphone
                                        </span>
                                    </label>
                                    <input type="number" placeholder="Enter Your Emergency Mobile Name 1">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">Open second modal</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Modal 2</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Hide this modal and show the first with the button below.
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">Back to first</button>
            </div>
        </div>
    </div>
</div>


@endsection


@section('scripts')
<script src="{{ asset('front_assets/js/client-jquery-2.2.0.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js"></script>
<script src="{{ asset('front_assets/custom_js/vehicle_details.js') }}"></script>
<!-- <script>
    window.addEventListener('load', function() {
        loadJS("{{ asset('admin_assets/js/popper.min.js') }}");
    });
</script> -->
@endsection
