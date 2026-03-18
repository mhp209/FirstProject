@extends('admin.layouts.app')

@section('content')
<div class="container-fluid mt-5">
    <div>
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-bs-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
        @endif
        @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-bs-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
        @endif
    </div>
    <div class="card-header border-bottom text-bg-primary">
        <h5 class="header-title">
            Add New User
        </h5>
    </div>
    <div class="card p-3">
        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <form method="post" action="{{ route('register') }}" data-parsley-validate id="users_validate" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">

                            <input type="hidden" name='barcodes' value="{{ $selectedBarcodes }}">
                            <input type="hidden" name='quantity' value="{{ $quantity }}">
                            <input type="hidden" name='price' value="{{ $price }}">

                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="first_name" class="form-label">First Name <span class="text text-danger">*</span></label>
                                    <input type="text" name="first_name"
                                    class="form-control @error('first_name') is-invalid @enderror" id="first_name" value=""
                                    placeholder="Enter Your First Name">
                                    @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="last_name" class="form-label">Last Name <span class="text text-danger">*</span></label>
                                    <input type="text" name="last_name"
                                    class="form-control @error('last_name') is-invalid @enderror" id="last_name"
                                    value=""
                                    placeholder="Please Enter Your Last Name">
                                    @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="email" class="form-label">Email Address <span class="text text-danger">*</span></label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="" placeholder="Enter Your Email" autocomplete="email">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="form-group" id="password-toggle">
                                    <label for="password" class="form-label">Password  @if($form_type =='add') <span class="text text-danger">*</span> @endif</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror password" name="password" placeholder="Enter Your Password" autocomplete="new-password" />
                                    <!-- <i class="fas fa-eye-slash" id="togglePassword"></i> -->
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="mobile_number" class="form-label">Mobile Number</label>
                                    <input type="number" name="mobile_number"
                                    class="form-control @error('mobile_number') is-invalid @enderror" id="mobile_number"
                                    value=""
                                    placeholder="Enter Your Mobile Number (eg:1234567890)">
                                    @error('mobile_number')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>       
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <a href="{{ url('barcode') }}" class="btn btn-danger mt-2">Cancel</a>
                                    <button class="btn btn-primary mr-1 mt-2">
                                        <i class="ri-user-add-fill me-1"></i> Submit
                                    </button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <!-- end row -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script rel="preload" src="{{ asset('admin_assets/js/custom/barcode.js') }}" as="script"></script>
@endsection
