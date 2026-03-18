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
        <h4 class="header-title">
            Setting Management
        </h4>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card p-3">
                <div class="card-header border-bottom text-bg-primary">
                    <h5 class="header-title">
                        Add/Update Setting
                    </h5>
                </div>
                <div class="card p-3 mb-3">
                    <form method="post" action="{{ route('setting.store') }}" data-parsley-validate id="discount_frm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $Setting->id }}">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="payment_mode" class="form-label">Payment Mode <span class="text text-danger">*</span></label>
                                    <select name="payment_mode"  name="payment_mode" class="form-control @error('payment_mode') is-invalid @enderror" id="payment_mode">
                                        <option value="test" {{ ($Setting->payment_mode == 'test') ? 'selected' : ''}}>Test</option>
                                        <option value="live" {{ ($Setting->payment_mode == 'live') ? 'selected' : ''}}>Live</option>
                                    </select>
                                    @error('spayment_modems')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="name" class="form-label">SMS Mode <span class="text text-danger">*</span></label>
                                    <select name="sms"  name="sms" class="form-control @error('sms') is-invalid @enderror" id="sms">
                                        <option value="0" {{ ($Setting->sms == '0') ? 'selected' : ''}}>False</option>
                                        <option value="1" {{ ($Setting->sms == '1') ? 'selected' : ''}}>True</option>
                                    </select>
                                    @error('sms')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="form-group">
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

@endsection
