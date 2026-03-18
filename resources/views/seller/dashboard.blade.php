@extends('admin.layouts.app')

@section('content')
<div class="content container-fluid">

    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Welcome {{ ucwords(auth()->user()->name) }}</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    <div class="row">
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="card dash-widget">
                <div class="card-body">
                    <span class="dash-widget-icon"><i class="fa fas fa-qrcode"></i></span>
                    <div class="dash-widget-info">
                        <h3>{{ $total_barcode }}</h3>
                        <span>Total Barcode </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="card dash-widget">
                <div class="card-body">
                    <span class="dash-widget-icon"><i class="fa fas fa-qrcode"></i></span>
                    <div class="dash-widget-info">
                        <h3>{{ $active_barcode }}</h3>
                        <span>Sold</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
