@extends('admin.layouts.app')

@section('content')
<div class="content container-fluid">
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


    <div class="faq-card">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    <a class="collapsed" data-bs-toggle="collapse" href="#collapseOne" aria-expanded="false">Generate Barcode</a>
                </h4>
            </div>
            <div id="collapseOne" class="card-collapse collapse">
                <div class="card-body">
                    <form method="post" action="{{ route('barcode.expert') }}" data-parsley-validate id="barcode_gen" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="barcode" class="form-label">Type <span class="text text-danger">*</span></label>
                                    <select name="type" id="type" class="form-control @error('type') is-invalid @enderror">
                                        <option value="">Select a type</option>
                                        <option value="web">Web</option>
                                        <option value="seller">Seller</option>
                                        <option value="franchise">Franchise</option>
                                        <option value="test">Test</option>
                                    </select>
                                    @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="wheeler_type" class="form-label">Wheeler Type </label>
                                    <select name="wheeler_type" id="wheeler_type" class="form-control">
                                        <option value="2 Wheeler">2 Wheeler</option>
                                        <option value="4 Wheeler">4 Wheeler</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="barcode" class="form-label">Number of Barcode <span class="text text-danger">*</span></label>
                                    <input type="number" name="number" min="1" class="form-control @error('number') is-invalid @enderror" id="number" value="" placeholder="Number Of Barcode">
                                    @error('number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <button class="btn btn-primary mr-1 mt-2" id="downloadAndRedirect">
                                        <i class="ri-user-add-fill me-1"></i> Generate Barcode
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card p-3">
        <h3 class="mb-0">Generate Barcode List</h3>
        <hr>

        @include('admin.includes.search')

        <table id="datatable" class="table table-centered mb-0 table-responsive w-100">
            <thead>
                <tr>
                    <th>Sr. No.</th>
                    <th>Barcode</th>
                    <th>Type</th>
                    <th>Wheeler Type</th>
                    <th>Linked</th>
                    <th>Customer</th>
                    <th>Seller</th>
                    <th>Uploaded By</th>
                    <th>Created Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

</div>
@php

$fileName = (session('fileName')) ? session('fileName') : '';
@endphp

@endsection

@section('script')
<script>
    var fileName = '{{ $fileName }}';
</script>
<script type="text/javascript" rel="preload" src="{{ asset('admin_assets/js/custom/barcode.js') }}" as="script"></script>
@endsection

