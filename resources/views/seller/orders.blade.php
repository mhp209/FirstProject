@extends('admin.layouts.app')

@section('content')
<div class="content container-fluid">
    <div class="card-header border-bottom text-bg-primary">
        <h4 class="header-title">
            Order List
        </h4>
    </div>
    <div class="row">

        <div class="col-12">
            <div class="card p-3">
                <div class="mb-2">
                    <a class="btn btn-primary float-right export" href="javascript:void(0);">Export</a>
                </div>

                @include('admin.includes.search')

                <table id="datatable" class="table table-centered mb-0 table-responsive w-100" aria-describedby="datatable" style="width:100%">
                    <thead>
                        <tr>
                            <th width="5%">Sr.</th>
                            <th>Order Id</th>
                            <th>Name</th>
                            <th>Sub Total</th>
                            <th>Discount</th>
                            <th>Total</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Promo Code</th>
                            <th>Order From</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                <div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection('content')

@section('script')

<script rel="preload" src="{{ asset('admin_assets/js/custom/seller_order.js') }}" as="script"></script>

@endsection
