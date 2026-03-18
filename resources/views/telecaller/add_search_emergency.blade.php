@extends('admin.layouts.app')

@section('content')
<div class="content container-fluid">

    <div class="card-header border-bottom text-bg-primary">
        <h5 class="header-title">
            Add Emergency
        </h5>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card p-3">
                <div class="card p-3 mb-3">
                    <form method="post" action="{{ url('admin/search') }}" data-parsley-validate id="roles_validate">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="vehicle_no" class="form-label">Vehicle Number <span class="text text-danger">*</span></label>
                                    <input type="text" name="vehicle_no" class="form-control @error('vehicle_no') is-invalid @enderror" id="vehicle_no" value="{{ $VehicleData->vehicle_no ? $VehicleData->vehicle_no : old('vehicle_no') }}" placeholder="Enter Your Vehical Number">
                                    @error('vehicle_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <a href="{{ url('admin/search') }}" class="btn btn-danger mt-2">Cancel</a>
                                    <button type="submit" class="btn btn-primary mr-1 mt-2">
                                        <i class="ri-user-add-fill me-1"></i> Search
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                @if(!empty($VehicleData->owner_name))
                <div class="card p-3">

                    <div class="container mt-5">
                        <h1 class="text-center">Vehicle Details</h1>
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
                                <h2>Vehicle Name/Model</h2>
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

                        <h1 class="text-center">Caller Details</h1>
                        <div class="">
                            <form method="post" action="{{ url('admin/emergency/store') }}" data-parsley-validate id="emergency_form">
                                @csrf
                                <input type="hidden" name="vehicle_id" value="{{ $VehicleData->id }}">
                                <input type="hidden" name="telecaller_id" value="{{ Auth::guard('admin')->user()->id }}">
                                <input type="hidden" name="vehicle_no" value="{{ $VehicleData->vehicle_no }}">

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label for="caller_name" class="form-label">Caller Name <span class="text text-danger">*</span></label>
                                                <input type="caller_name" name="caller_name" class="form-control @error('caller_name') is-invalid @enderror" id="caller_name" value="" placeholder="Enter Your Caller Name">
                                                @error('caller_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label for="caller_number" class="form-label">Caller Number <span class="text text-danger">*</span></label>
                                                <input type="caller_number" name="caller_number" class="form-control @error('caller_number') is-invalid @enderror" id="caller_number" value="" placeholder="Enter Your Caller Number">
                                                @error('caller_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label for="location" class="form-label">Location <span class="text text-danger">*</span></label>
                                                <input type="location" name="location" class="form-control @error('location') is-invalid @enderror" id="location" value="" placeholder="Enter Location">
                                                @error('location')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <div class="form-group">
                                                <label for="description" class="form-label">Description <span class="text text-danger">*</span></label>
                                                <textarea name="description" id="editor" cols="100%" rows="5" class="ckeditor"></textarea>
                                                @error('description')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <button type="submit" class="btn btn-primary"> Add Emergency </button>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                @endif

                @if(isset($error))
                <div class="card p-3">
                    <h4>{{ $error }}</h4>
                </div>
                @endif
            </div>
        </div>
    </div>


</div>
@endsection

@section('script')
<script rel="preload" src="{{ asset('admin_assets/js/custom/telecaller.js') }}" as="script"></script>
@endsection
