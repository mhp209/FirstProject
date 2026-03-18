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
            Discount Management
        </h5>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card p-3">
                <div class="card-header border-bottom text-bg-primary">
                    <h5 class="header-title">
                        Add/Update Discount
                    </h5>
                </div>
                <div class="card p-3 mb-3">
                    <form method="post" action="{{ route('discount.store') }}" data-parsley-validate id="discount_frm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $discount->id }}">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="name" class="form-label">Discount Quantity <span class="text text-danger">*</span></label>
                                    <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror" id="quantity" value="{{ $discount->quantity ? $discount->quantity : old('quantity') }}" placeholder="Enter Quantity">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="name" class="form-label">Discount <span class="text text-danger">*</span></label>
                                    <select name="discount"  name="discount" class="form-control @error('discount') is-invalid @enderror" id="discount">
                                        @for ($i = 1; $i <= 100; $i++)
                                            <option value="{{ $i }}" {{ ($discount->discount == $i) ? 'selected' : ''}}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                    @error('discount')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <a href="{{ url('admin/banner') }}" class="btn btn-danger mt-2">Cancel</a>
                                    <button class="btn btn-primary mr-1 mt-2">
                                        <i class="ri-user-add-fill me-1"></i> Submit
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
    <script rel="preload" src="{{ asset('admin_assets/js/custom/discount.js') }}" as="script"></script>
@endsection
