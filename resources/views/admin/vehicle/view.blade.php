<div class="container">
    <!-- <h1 class="text-center">Vehicle Details</h1> -->
    <div class="row">
        <div class="col-md-6">
            @if(!empty($VehicleData->image))
            @php
            $images = explode(',',$VehicleData->image);
            @endphp
            <img src="{{ VEHICLE_IMG_URL.$images[0] }}" alt="Vehicle Image" class="img-fluid">
            @else
            <img src="{{ asset('admin_assets/img/vehicle_image.png') }}" alt="Vehicle Image" class="img-fluid">
            @endif
        </div>
        <div class="col-md-6">
            <p><strong>Owner: </strong> {{ $VehicleData->owner_name }}</p>
            <p><strong>Company: </strong> {{ vehicleBrands($VehicleData->brand)}} {{ vehicleModel($VehicleData->model)}}</p>
            <p><strong>Mobile No: </strong> {{ $VehicleData->mobile_number }}</p>

            <p><strong>Emergency Contact Name 1: </strong> {{ $VehicleData->emergency_name1 }}</p>
            <p><strong>Relation With Emergency Contact 1: </strong> {{ $VehicleData->relation_emg1 }}</p>
            <p><strong>Emergency Contact Number 1: </strong> {{ $VehicleData->emergency_number1 }}</p>

            <p><strong>Emergency Contact Name 2: </strong> {{ $VehicleData->emergency_name2 }}</p>
            <p><strong>Relation With Emergency Contact 2: </strong> {{ $VehicleData->relation_emg2 }}</p>
            <p><strong>Emergency Contact Number 2: </strong> {{ $VehicleData->emergency_number2 }}</p>

            <p><strong>Registration No: </strong> {{$VehicleData->registration_no}}</p>
        </div>
    </div>
</div>
