@extends('front.layout.master')

@section('content')
@php
$vehicleImages = $vehicle->image;
if(!empty($vehicleImages)){
$vehicleImages = explode(',',$vehicleImages);
if(count($vehicleImages) == 1)
$vehicleImages[] = $vehicleImages[0];
}else{
$vehicleImages = [];
}
@endphp


<section id="user-vehicle-details">
    <div class="container">
        <div class="section-title text-center ">
            <h1>user vehicle details</h1>
        </div>
    </div>
</section>

<section id="user-vehicle-datelis-wrapper">
    <div class="container">
        <div class="row gy-3">
            <div class="back-btn">
                <a href="{{ route('vehicle.details') }}" class="gap-2">
                    <span class="material-symbols-outlined">
                        arrow_back
                    </span>
                    back
                </a>
            </div>
            <div class="col-lg-4">

                @if(count($vehicleImages) > 0)
                <div class="vehicle-slider">
                    <div id="my-vehicle-img" class="my-vehicleimg-wrapper">
                        @foreach($vehicleImages as $image)
                        <div class="images">
                            <img src="{{ VEHICLE_IMG_URL.$image }}" alt="" class="img-fluid">
                        </div>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="images">
                    <img src="{{ asset('front_assets/images/car-track-img.png') }}" alt="" class="img-fluid">
                </div>
                @endif
            </div>
            <div class="col-lg-8">
                <div class="details-show-wrapper">
                    <div class="col-lg-5 car-details-show">
                        <div class="images">
                            <img src="{{ asset('front_assets/images/r-img-2.png') }} " alt="" class="img-fluid">
                        </div>
                        <div class="barcode-wrapper my-auto ">
                            <h5>{{ $vehicle->vehicle_no }}</h5>
                            <div class="model-name">
                                <h6>{{ vehicleBrands($vehicle->brand) }} {{ vehicleModel($vehicle->model) }}</h6>
                            </div>
                        </div>

                    </div>
                    <hr>
                    <div class=" details-wrapper col-lg-12 ">
                        <div class="col-lg-4 owner-name text-center ">
                            <h5>Owner name</h5>
                            <p>{{ $vehicle->owner_name }}</p>
                        </div>
                        <div class="col-lg-4 bar-code-wrapper text-center">
                            <h5>Barcode</h5>
                            <p>{{ $vehicle->barcode }}</p>
                        </div>
                        <div class="col-lg-4 mobile-num text-center">
                            <h5>mobile</h5>
                            <p>{{ $vehicle->mobile_number }}</p>
                        </div>
                    </div>
                    <div class=" details-wrapper-2 clo-lg-12 d-flex">
                        <div class="col-lg-4 owner-name text-center ">
                            <h5>vehicle type</h5>
                            <p>{{ $vehicle->vehicle_type }}</p>
                        </div>
                        <div class="col-lg-4 bar-code-wrapper text-center">
                            <h5>license no.</h5>
                            <p>{{ $vehicle->license_no }}</p>
                        </div>
                        <div class="col-lg-4 mobile-num text-center">
                            <h5>rc no</h5>
                            <p>{{ $vehicle->rc_no }}</p>
                        </div>
                    </div>
                    <div class="documents-wrapper clo-lg-12 d-flex">
                        @if(isset($VehicleDocuments['rc']))
                        <div class="col-lg-4 owner-name text-center ">
                            <a href="{{ VEHICLE_URL.$VehicleDocuments['rc'] }}" target="_blank">Rc Documents</a>
                        </div>
                        @endif
                        @if(isset($VehicleDocuments['insurance']))
                        <div class="col-lg-4 bar-code-wrapper text-center">
                            <a href="{{ VEHICLE_URL.$VehicleDocuments['insurance'] }}" target="_blank">insurance Documents</a>
                        </div>
                        @endif
                        @if(isset($VehicleDocuments['puc']))
                        <div class="col-lg-4 mobile-num text-center">
                            <a href="{{ VEHICLE_URL.$VehicleDocuments['puc'] }}" target="_blank">puc Documents</a>
                        </div>
                        @endif
                    </div>
                    <div class=" emergency-details clo-lg-12 d-flex">
                        <div class="col-lg-4 owner-name text-center ">
                            <h5>person name</h5>
                            <p>{{ $vehicle->emergency_name1 }}</p>
                        </div>
                        <div class="col-lg-4 bar-code-wrapper text-center">
                            <h5>relation person</h5>
                            <p>{{ $vehicle->relation_emg1 }}</p>
                        </div>
                        <div class="col-lg-4 mobile-num text-center">
                            <h5>emergency contact</h5>
                            <p>{{ $vehicle->emergency_number1 }}</p>
                        </div>
                    </div>
                    @if(!empty($vehicle->emergency_name2))
                    <div class=" emergency-details-2 clo-lg-12 d-flex ">
                        <div class="col-lg-4 bar-code-wrapper text-center">
                            <h5>person name</h5>
                            <p>{{ $vehicle->emergency_name2 }}</p>
                        </div>
                        <div class="col-lg-4 mobile-num text-center">
                            <h5>relation person</h5>
                            <p>{{ $vehicle->relation_emg2 }}</p>
                        </div>
                        <div class="col-lg-4 owner-name text-center ">
                            <h5>emergency contact</h5>
                            <p>{{ $vehicle->emergency_number2 }}</p>
                        </div>
                    </div>
                    @endif

                    <div class=" emergency-details-2 clo-lg-12 d-flex">
                        <div class="col-lg-4 bar-code-wrapper text-center">
                            <h5>License Expiry Date</h5>
                            <p>{{ $vehicle->license_ending_date }}</p>
                        </div>
                        <div class="col-lg-4 mobile-num text-center">
                            <h5>Insurance Expiry Date</h5>
                            <p>{{ $vehicle->inurance_ending_date }}</p>
                        </div>
                        <div class="col-lg-4 owner-name text-center ">
                            <h5>PUC Expiry Date</h5>
                            <p>{{ $vehicle->puc_ending_date }}</p>
                        </div>
                    </div>

                    <div class=" emergency-details-2 clo-lg-12 d-flex">
                        <div class="col-lg-4 owner-name text-center ">
                            <h5>Service Date</h5>
                            <p>{{ $vehicle->service_date }}</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script src="{{ asset('front_assets/js/client-jquery-2.2.0.min.js') }}" defer></script>
<script src="{{ asset('front_assets/js/client-slick.js') }}" defer></script>
<script src="{{ asset('front_assets/custom_js/info_vehicle.js') }}" defer></script>


@endsection
