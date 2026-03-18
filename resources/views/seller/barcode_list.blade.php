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

        <div class="card-header border-bottom text-bg-primary">
            <h5 class="header-title">
                Barcode Management
            </h5>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card p-3">
                    <div class="mb-2">
                        <div>
                            <button id="add_cust_del" class="btn btn-primary d-flex" title="Add-customer details">
                                <i class="ri-user-add-fill me-1">Set customer details</i>
                            </button>
                        </div>
                    </div>

                    <!-- @include('admin.includes.search') -->

                    <table id="seller_barcode_table" class="table table-centered mb-0 table-responsive w-100"
                        aria-describedby="user_table_info">
                        <thead>
                            <tr>
                                <th width="5%">Checkbox</th>
                                <th>Barcode</th>
                                <th>Customer Name</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script rel="preload" src="{{ asset('admin_assets/js/custom/seller_barcode.js') }}" as="script"></script>
@endsection
