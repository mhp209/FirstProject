@extends('front.layout.master')

@section('content')

@php
$images = [];
if($title == "Add")
$actionUrl = route('store.vehicle');
else
$actionUrl = route('update.vehicle');
@endphp


<script>
    var model_id = '<?= $vehicleData->model ?>';
    var title = '<?= $title ?>';
    // console.log(title);
    if (title == "Add") {
        var actionUrl = "{{ route('store.vehicle') }}";
    }
    if (title == "Update") {
        var actionUrl = "{{ route('update.vehicle') }}";
    }
    // console.log(actionUrl);
</script>

<section id="about-us-banner">
    <div class="container ">
        <div class="section-title text-center ">
            <h1>{{ $title }} Vehicle</h1>
        </div>
</section>

<section id="link-vehicle-wrapper">
    <div class="container">
        <form id="add_vehicle_frm" method="post" action="{{ $actionUrl }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            @if($title == "Update")
            <input type="hidden" name="id" value="{{ $vehicleData->id }}">
            @endif
            <div class="row d-flex ">

                <div class="content">
                    <h3>vehicle Details</h3>
                </div>
                <div class="back-btn">
                    <a href="{{ route('vehicle.details') }}" class="gap-2">
                        <span class="material-symbols-outlined">
                            arrow_back
                        </span>
                        back
                    </a>
                </div>
                <div class="col-lg-4 barcode">
                    <h5>Barcode <span class="text-danger">*</span></h5>
                    <label class="justify-content-center align-items-center ">
                        <span>
                            <img src="{{ asset('front_assets/images/qr-code.svg') }}" alt="">
                        </span>
                    </label>
                    <input type="text" name="barcode" class="form-control @error('barcode') is-invalid @enderror" id="barcode" value="{{ ($vehicleData->barcode)? $vehicleData->barcode : old('barcode') }}" placeholder="Create Barcode" data-custom-message="">
                    @error('barcode')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <div id="barcode-error1" class="error invalid-feedback" for="barcode" style="display: inline-block;"></div>
                </div>
                <div class="col-lg-4 vechicle-number">
                    <h5>vehicle no<span class="text-danger">*</span></h5>
                    <label class="justify-content-center align-items-center ">
                        <span class="material-symbols-outlined">
                            format_list_numbered
                        </span>
                    </label>
                    <input type="text" name="vehicle_no" class="form-control @error('vehicle_no') is-invalid @enderror" placeholder="Enter Your Vehicle Number" id="vehicle_no" value="{{ ($vehicleData->vehicle_no)? $vehicleData->vehicle_no : old('vehicle_no') }}">
                    @error('vehicle_no')
                    <div class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </div>
                    @enderror
                </div>
                <div class="col-lg-4 owner-name">
                    <h5>owner name<span class="text-danger">*</span></h5>
                    <label class="justify-content-center align-items-center ">
                        <span class="material-symbols-outlined">
                            person
                        </span>
                    </label>
                    <input type="text" name="owner_name" class="form-control @error('owner_name') is-invalid @enderror" value="{{ ($vehicleData->owner_name)? $vehicleData->owner_name : old('owner_name') }}" placeholder="Enter Your Owner Name">
                    @error('owner_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-lg-4 mobile-number">
                    <h5>mobile no<span class="text-danger">*</span></h5>
                    <label class="justify-content-center align-items-center ">
                        <span class="material-symbols-outlined">
                            phone_iphone
                        </span>
                    </label>
                    <input type="number" min="0" required placeholder="Enter Your Mobile Number" name="mobile_number" class="form-control @error('mobile_number') is-invalid @enderror" id="mobile_number" value="{{ ($vehicleData->mobile_number)? $vehicleData->mobile_number : old('mobile_number') }}">
                    @error('mobile_number')
                    <span class="invalid-feedback" role="alert">
                        <span>{{ $message }}</span>
                    </span>
                    @enderror
                </div>
                <div class="col-lg-4 license-number">
                    <h5>license no</h5>
                    <label class="justify-content-center align-items-center ">
                        <span class="material-symbols-outlined">
                            format_list_numbered
                        </span>
                    </label>
                    <input type="text" name="license_no" class="form-control @error('license_no') is-invalid @enderror" id="license_no" value="{{ ($vehicleData->license_no)? $vehicleData->license_no : old('license_no') }}" placeholder="Enter Your Vehicle License No">
                    @error('license_no')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-lg-4 rc-number">
                    <h5>RC no</h5>
                    <label class="justify-content-center align-items-center ">
                        <span class="material-symbols-outlined">
                            format_list_numbered
                        </span>
                    </label>
                    <input type="text" name="rc_no" class="form-control @error('rc_no') is-invalid @enderror" id="rc_no" value="{{ ($vehicleData->rc_no)? $vehicleData->rc_no : old('rc_no') }}" placeholder="Enter Your Vehicle RC No">
                    @error('rc_no')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-lg-4 vechicle-name">
                    <h5>vehicle type<span class="text-danger">*</span></h5>
                    <select name="vehicle_type" id="vehicle_type" class="form-control @error('vehicle_type') is-invalid @enderror">
                        <option value="">Select a Vehicle Type</option>
                        @foreach (vehicleTypes() as $type)
                        <option value="{{ $type }}" <?= ($type == $vehicleData->vehicle_type) ? 'selected' : '' ?>>{{ $type }}</option>
                        @endforeach
                    </select>
                    @error('vehicle_type')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-lg-4 brand-name">
                    <h5>brand name<span class="text-danger">*</span></h5>
                    <select name="brand" id="brand" class="form-control @error('brand') is-invalid @enderror">
                        <option value="">Select a Vehicle Brand Name</option>
                        @foreach (vehicleBrands() as $brand)
                        <option value="{{ $brand->id }}" <?= ($brand->id == $vehicleData->brand) ? 'selected' : '' ?>>{{ $brand->name }}</option>
                        @endforeach
                    </select>
                    @error('brand')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-lg-4 model-name">
                    <h5>model<span class="text-danger">*</span></h5>
                    <select name="model" id="model" class="form-control @error('model') is-invalid @enderror">
                        <option value="">Select a Vehicle Model Name</option>
                    </select>
                    @error('model')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-lg-4 mobile-number hide" id="other_model_name">
                    <h5>Model Name<span class="text-danger">*</span></h5>
                    <label class="justify-content-center align-items-center ">
                        <span class="material-symbols-outlined">
                            directions_car
                        </span>
                    </label>
                    <input type="text" name="model_name" id="model_name" class="form-control @error('model_name') is-invalid @enderror" placeholder="Enter Your Model Name">
                    <div id="model-error" class="error invalid-feedback" for="model" style="display: inline-block;"></div>
                </div>

                <hr>
                <h3>Emergency Details</h3>

                <div class="col-lg-4 mobile-number">
                    <h5>Emergency Contact Name 1<span class="text-danger">*</span></h5>
                    <label class="justify-content-center align-items-center ">
                        <span class="material-symbols-outlined">
                            person
                        </span>
                    </label>
                    <input type="text" name="emergency_name1" class="form-control @error('emergency_name1') is-invalid @enderror" id="emergency_name1" value="{{ ($vehicleData->emergency_name1)? $vehicleData->emergency_name1 : old('emergency_name1') }}" placeholder="Enter Your Emergency Contact Name 1">
                </div>
                @error('emergency_name1')
                <span id="emergency_name1-error" class="error invalid-feedback" for="emergency_name1" style="display: inline-block;">{{ $message }}</span>
                <!-- <span class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span> -->
                @enderror
                <div class="col-lg-4 mobile-number">
                    <h5>Relation With Emergency Contact 1<span class="text-danger">*</span></h5>
                    <label class="justify-content-center align-items-center ">
                        <span class="material-symbols-outlined">
                            person
                        </span>
                    </label>
                    <input type="text" name="relation_emg1" class="form-control @error('relation_emg1') is-invalid @enderror" id="relation_emg1" value="{{ ($vehicleData->relation_emg1)? $vehicleData->relation_emg1 : old('relation_emg1') }}" placeholder="Enter Your Relation Emergency Contact Name 1">
                    @error('relation_emg1')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-lg-4 mobile-number">
                    <h5>Emergency mobile no.1<span class="text-danger">*</span></h5>
                    <label class="justify-content-center align-items-center ">
                        <span class="material-symbols-outlined">
                            phone_iphone
                        </span>
                    </label>
                    <input type="number" min="0" name="emergency_number1" class="form-control @error('emergency_number1') is-invalid @enderror" id="emergency_number1" value="{{ ($vehicleData->emergency_number1)? $vehicleData->emergency_number1 : old('emergency_number1') }}" placeholder="Enter Your Emergency Mobile Number 1">
                    @error('emergency_number1')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-lg-4 mobile-number">
                    <h5>Emergency Contact Name 2 <span class="text-danger"></span></h5>
                    <label class="justify-content-center align-items-center ">
                        <span class="material-symbols-outlined">
                            person
                        </span>
                    </label>
                    <input type="text" name="emergency_name2" class="form-control" id="emergency_name2" value="{{ ($vehicleData->emergency_name2)? $vehicleData->emergency_name2 : old('emergency_name2') }}" placeholder="Enter Your Emergency Contact Name 2">
                </div>
                <div class="col-lg-4 mobile-number">
                    <h5>Relation with Emergency Contact no.2<span class="text-danger"></span></h5>
                    <label class="justify-content-center align-items-center ">
                        <span class="material-symbols-outlined">
                            person
                        </span>
                    </label>
                    <input type="text" name="relation_emg2" class="form-control" id="relation_emg2" value="{{ ($vehicleData->relation_emg2)? $vehicleData->relation_emg2 : old('relation_emg2') }}" placeholder="Enter Your Relation Emergency Contact 2">
                </div>
                <div class="col-lg-4 mobile-number">
                    <h5>Emergency mobile no.2<span class="text-danger"></span></h5>
                    <label class="justify-content-center align-items-center ">
                        <span class="material-symbols-outlined">
                            phone_iphone
                        </span>
                    </label>
                    <input type="number" min="0" name="emergency_number2" class="form-control " id="emergency_number2" value="{{ ($vehicleData->emergency_number2)? $vehicleData->emergency_number2 : old('emergency_number2') }}" placeholder="Enter Your Emergency Mobile Number 2">
                </div>

                <hr>
                <h3>Documents & Images Upload</h3>

                <div class="col-lg-4 license-expiry">
                    <h5>license expiry date</h5>
                    <label class="justify-content-center align-items-center">
                        <span class="material-symbols-outlined">
                            date_range
                        </span>
                    </label>
                    <input type="date" placeholder="" id="calendar-container" name="license_ending_date" class="form-control @error('license_ending_date') is-invalid @enderror" value="{{ ($vehicleData->license_ending_date)? $vehicleData->license_ending_date : old('license_ending_date') }}">
                    @error('license_ending_date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-lg-4 license-expiry">
                    <h5>insurance expiry date</h5>
                    <label class="justify-content-center align-items-center">
                        <span class="material-symbols-outlined">
                            date_range
                        </span>
                    </label>
                    <input type="date" placeholder="" id="calendar-container" name="inurance_ending_date" class="form-control @error('inurance_ending_date') is-invalid @enderror" value="{{ ($vehicleData->inurance_ending_date)? $vehicleData->inurance_ending_date : old('inurance_ending_date') }}">
                    @error('inurance_ending_date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-lg-4 license-expiry">
                    <h5>PUC expiry date</h5>
                    <label class="justify-content-center align-items-center">
                        <span class="material-symbols-outlined">
                            date_range
                        </span>
                    </label>
                    <input type="date" placeholder="" id="calendar-container" name="puc_ending_date" class="form-control @error('puc_ending_date') is-invalid @enderror" value="{{ ($vehicleData->puc_ending_date)? $vehicleData->puc_ending_date : old('puc_ending_date') }}">
                    @error('puc_ending_date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-lg-4 license-expiry">
                    <h5>Service date</h5>
                    <label class="justify-content-center align-items-center">
                        <span class="material-symbols-outlined">
                            date_range
                        </span>
                    </label>
                    <input type="date" placeholder="" id="calendar-container" name="service_date" class="form-control @error('service_date') is-invalid @enderror" value="{{ ($vehicleData->service_date)? $vehicleData->service_date : old('service_date') }}">
                    @error('service_date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-lg-4 vechicle-images">
                    <div class="name gap-5">
                        <h5>Vehicle Images</h5>
                        @if(!empty($vehicleData->image))
                        <div class="view">
                            <a class="" data-bs-toggle="modal" href="#exampleModalToggle" role="button" title="Vehicle Image">
                                <span class="material-symbols-outlined">
                                    visibility
                                </span>
                            </a>
                        </div>
                        @endif
                    </div>
                    <label class="justify-content-center align-items-center ">
                        <span class="material-symbols-outlined">
                            image
                        </span>
                    </label>
                    <input type="file" id="image" name="image[]" accept="image/*" class="@error('image') is-invalid @enderror" id="image" value="" multiple>
                    @error('image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-lg-4 insurance-document">
                    <div class="name gap-5">
                        <h5>RC document</h5>
                        <div class="view">
                            @if(isset($VehicleDocuments['rc']))
                            <a href="{{ VEHICLE_URL.$VehicleDocuments['rc'] }}" target="_blank" role="button" title="RC Document">
                                <span class="material-symbols-outlined">
                                    visibility
                                </span></a>
                            @endif
                        </div>
                    </div>
                    <label class="justify-content-center align-items-center ">
                        <span class="material-symbols-outlined">
                            file_upload
                        </span>
                    </label>
                    <input type="file" name="vehicle_documents[rc]" accept=".pdf, .doc, .docx, .jpg, .jpeg, .png" class="@error('vehicle_document') is-invalid @enderror">
                </div>
                <div class="col-lg-4 insurance-document">
                    <div class="name gap-5">
                        <h5>Insurance document</h5>
                        <div class="view">
                            @if(isset($VehicleDocuments['insurance']))
                            <a href="{{ VEHICLE_URL.$VehicleDocuments['insurance'] }}" target="_blank" role="button" title="Insurance Document">
                                <span class="material-symbols-outlined">
                                    visibility
                                </span></a>
                            @endif
                        </div>
                    </div>
                    <label class="justify-content-center align-items-center ">
                        <span class="material-symbols-outlined">
                            file_upload
                        </span>
                    </label>
                    <input type="file" name="vehicle_documents[insurance]" accept=".pdf, .doc, .docx, .jpg, .jpeg, .png" class="@error('vehicle_document') is-invalid @enderror">

                </div>
                <div class="col-lg-4 puc-document">
                    <div class="name gap-5">
                        <h5>PUC document</h5>
                        <div class="view">
                            @if(isset($VehicleDocuments['puc']))
                            <a href="{{ VEHICLE_URL.$VehicleDocuments['puc'] }}" target="_blank" role="button" title="PUC Document">
                                <span class="material-symbols-outlined">
                                    visibility
                                </span></a>
                            @endif
                        </div>
                    </div>
                    <label class="justify-content-center align-items-center ">
                        <span class="material-symbols-outlined">
                            file_upload
                        </span>
                    </label>
                    <input type="file" name="vehicle_documents[puc]" accept=".pdf, .doc, .docx, .jpg, .jpeg, .png" class="@error('vehicle_document') is-invalid @enderror">
                </div>

                <div class="edit-profile">
                    <button type="submit" class="chechout-btn"> {{ $title }} Vehicle </button>
                </div>
            </div>
        </form>

        @if(!empty($vehicleData->image))
        <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalToggleLabel">Vehicle Images</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center ">
                        <div id="image-preview-container" class="image-preview-container" style="display: inline-flex;">
                            @php
                            $images = explode(',',$vehicleData->image);
                            @endphp
                            @foreach ($images as $img)
                            <div class="image-preview">
                                <img src="{{ VEHICLE_IMG_URL.$img }}" data-id="{{ $vehicleData->id }}" data-name="{{ $img }}" class="img-fluid ">
                                <button type="button" class="img-delete-button delete-button">x</button>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>



@endsection

@section('scripts')
<script type="text/javascript">
    var imageCount = '<?php echo count($images) ?>';
    // console.log(imageCount);
</script>

<script>
    window.addEventListener('load', function() {
        loadJS("{{ asset('front_assets/js/jquery.validate.min.js') }}");
        loadJS("{{ asset('front_assets/custom_js/vehicle.js') }}");
    });
</script>
@endsection
