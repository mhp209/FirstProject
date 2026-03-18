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
            Add Insurance
        </h5>
    </div>
    <div class="card p-3">
        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <form id="insurance_qut_frm" method="post" action="{{ route('admin.storeInsurance') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="insurance_alias" class="form-label">Insurance Alias <span class="text text-danger">*</span></label>
                                    <select name="insurance_alias" id="insurance_alias" class="form-control @error('insurance_alias') is-invalid @enderror">
                                        <option value="">Select a Insurance Alias</option>
                                        @foreach ($ins_alias as $alias)
                                        <option value="{{ $alias->alias }}">{{ $alias->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('insurance_alias')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="first_name" class="form-label">First Name <span class="text text-danger">*</span></label>
                                    <input type="text" name="first_name" id="first_name" class="form-control @error('first_name') is-invalid @enderror" placeholder="Please Enter First Name">
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
                                    <input type="text" name="last_name" id="last_name" class="form-control @error('last_name') is-invalid @enderror" placeholder="Please Enter Last Name">
                                    @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="mobile_number" class="form-label">Mobile Number <span class="text text-danger">*</span></label>
                                    <input type="number" name="mobile_number" id="mobile_number" min="1" class="form-control @error('mobile_number') is-invalid @enderror" placeholder="Please Enter Mobile number">
                                    @error('mobile_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="email" class="form-label">Email <span class="text text-danger">*</span></label>
                                    <input type="text" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Please Enter Email">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="message" class="form-label">Message </label>
                                    <textarea name="message" class="form-control @error('message') is-invalid @enderror" placeholder="Message" id="" cols="10" rows="4"></textarea>
                                    @error('message')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <a href="{{ route('admin.ins_enquiry') }}" class="btn btn-danger mt-2">Cancel</a>
                                    <button class="btn btn-primary mr-1 mt-2" id="assign_btn">
                                        <i class="ri-user-add-fill me-1"></i> submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('script')
<script rel="preload" src="{{ asset('admin_assets/js/custom/insurance.js') }}" as="script"></script>
@endsection
