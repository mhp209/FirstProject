@extends('admin.layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/daterangepicker.css') }}">
@endsection

@section('content')
<div class="content container-fluid dashboard">

    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Welcome Nikshit Patel!</h3>
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
                    <span class="dash-widget-icon"><i class="fa fa-solid fa-money"></i></span>
                    <div class="dash-widget-info">
                        <h3>₹{{ price_format($pageData['total_revenue']) }} </h3>
                        <span>Total Revenue</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="card dash-widget">
                <div class="card-body">
                    <span class="dash-widget-icon"><i class="fa fas fa-qrcode"></i></span>
                    <div class="dash-widget-info">
                        <h3> {{ $pageData['total_barcode'] }} </h3>
                        <span>Total Barcode</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="card dash-widget">
                <div class="card-body">
                    <span class="dash-widget-icon"><i class="fa fa-solid fa-users"></i></span>
                    <div class="dash-widget-info">
                        <h3> {{ $pageData['total_user'] }} </h3>
                        <span>Users</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="card dash-widget">
                <div class="card-body">
                    <span class="dash-widget-icon"><i class="fa fas fa-question-circle"></i></span>
                    <div class="dash-widget-info">
                        <h3> {{ $pageData['total_enquiry'] }} </h3>
                        <span>Emergency Call</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row">

        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="card dash-widget">
                <div class="card-body">
                    <span class="dash-widget-icon"><i class="fa fa-user"></i></span>
                    <div class="dash-widget-info">
                        <h3>{{ $pageData['total_seller'] }}</h3>
                        <span>Seller</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="card dash-widget">
                <div class="card-body">
                    <span class="dash-widget-icon"><i class="fa fas fa-qrcode"></i></span>
                    <div class="dash-widget-info">
                        <h3> {{ $pageData['web_barcode'] }} </h3>
                        <span>Web Barcode</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="card dash-widget">
                <div class="card-body">
                    <span class="dash-widget-icon"><i class="fa fas fa-qrcode"></i></span>
                    <div class="dash-widget-info">
                        <h3> {{ $pageData['seller_barcode'] }} </h3>
                        <span>Seller Barcode</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="card dash-widget">
                <div class="card-body">
                    <span class="dash-widget-icon"><i class="fa fas fa-qrcode"></i></span>
                    <div class="dash-widget-info">
                        <h3>{{ $pageData['franchise_barcode'] }}</h3>
                        <span>Franchise Barcode</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <!-- Order  -->
        <div class="col-md-6 d-flex">
            <div class="card card-table flex-fill">
                <div class="card-header">
                    <h3 class="card-title mb-0">Recent Order</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table custom-table table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th>Owner ID</th>
                                    <th>Name</th>
                                    <th>Total Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($pageData['recent_order']) > 0)
                                @foreach($pageData['recent_order'] as $order)
                                <tr>
                                    <td>{{ $order->order_id }}</td>
                                    <td>{{ ucwords($order->name) }}</td>
                                    <td>{{ price_format($order->total_amount) }}</td>
                                    <td class="text-center"><a class="action_icon" href="{{ url('admin/order',$order->id )}}" data-id="{{ $order->id }}" title="View"><i class="fa fa-eye"></i></a></td>
                                </tr>
                                @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center">No Data</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                @if(count($pageData['recent_order']) > 0)
                    <div class="card-footer">
                        <a href="{{ route('order.list') }}">View all Order</a>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-md-6 d-flex chartHeight">
            <div class="card card-table flex-fill">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center card-height">
                    <h3 class="card-title mb-0">Order Chart</h3>
                    <div class="from-group">
                        <input type="text" class="form-control" id="OrderDateRange" >
                    </div>
                </div>
                <div class="card-body">
                    <div id="OrderChart" style="height:100%"></div>
                </div>
            </div>
        </div>

        <!--End Orders -->

        <!-- Alerts -->
        <div class="col-md-6 d-flex">
            <div class="card card-table flex-fill">
                <div class="card-header">
                    <h3 class="card-title mb-0">Recent Alerts </h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table custom-table mb-0" width="100%">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Vehicle No.</th>
                                    <th>Mobile</th>
                                    <th>Alert Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($pageData['recent_alert']) > 0)
                                @foreach($pageData['recent_alert'] as $alert)
                                <tr>
                                    <td>{{ $alert->created_at }}</td>
                                    <td>{{ $alert->vehicle_no }}</td>
                                    <td>{{ $alert->mobile_number }}</td>
                                    <td>{{ $alert->type }}</td>
                                    <td class="text-center"><a class="action_icon view_alert" data-id="{{ $alert->id }}" title="View"><i class="fa fa-eye"></i></a></td>
                                </tr>
                                @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center">No Data</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                @if(count($pageData['recent_alert']) > 0)
                    <div class="card-footer">
                        <a href="{{ route('alert.list') }}">View all SMS Alerts</a>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-md-6 d-flex chartHeight">
            <div class="card card-table flex-fill">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center card-height">
                    <h3 class="card-title mb-0">Alert Chart</h3>
                    <div class="from-group">
                        <input type="text" class="form-control" id="AlertDateRange" >
                    </div>
                </div>
                <div class="card-body">
                    <div id="AlertChart" style="height:100%"></div>
                </div>
            </div>
        </div>

        <!--End Alerts -->

        <!-- Emergency -->
        <div class="col-md-6 d-flex">
            <div class="card card-table flex-fill">
                <div class="card-header">
                    <h3 class="card-title mb-0">Emergency Call </h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table custom-table mb-0" width="100%">
                            <thead>
                                <tr>
                                    <th>Caller Name</th>
                                    <th>Caller Number</th>
                                    <th>Telecaller Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($pageData['recent_emegrency']) > 0)
                                @foreach($pageData['recent_emegrency'] as $emergency)
                                <tr>
                                    <td>{{ ucwords($emergency->caller_name) }}</td>
                                    <td>{{ $emergency->caller_number }}</td>
                                    <td>{{ ucwords($emergency->adminRole->name ?? "") }}</td>
                                    <td class="text-center"><a class="action_icon view_emergency" data-id="{{ $emergency->id }}" title="View"><i class="fa fa-eye"></i></a></td>
                                </tr>
                                @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center">No Data</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                @if(count($pageData['recent_emegrency']) > 0)
                    <div class="card-footer">
                        <a href="{{ route('admin.emergency') }}">View all Emergency</a>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-md-6 d-flex chartHeight">
            <div class="card card-table flex-fill">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center card-height">
                    <h3 class="card-title mb-0">Emergency Chart</h3>
                    <div class="from-group">
                        <input type="text" class="form-control" id="EmergencyDateRange" >
                    </div>
                </div>
                <div class="card-body">
                    <div id="EmergencyChart" style="height:100%"></div>
                </div>
            </div>
        </div>

        <!--End Emergency  -->

        <!-- Users -->
        <div class="col-md-6 d-flex">
            <div class="card card-table flex-fill">
                <div class="card-header">
                    <h3 class="card-title mb-0">Recent Users</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-nowrap custom-table mb-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($pageData['recent_user']) > 0)
                                @foreach($pageData['recent_user'] as $user)
                                <tr>
                                    <td>{{ ucwords($user->name) }}</td>
                                    <td>{{ $user->mobile_number }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at }}</td>
                                   <!--  <td><a class="action_icon view_user" data-id="{{ $user->id }}"><i class="fa fa-eye"></i></a></td>  -->
                                </tr>
                                @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center">No Data</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                @if(count($pageData['recent_user']) > 0)
                <div class="card-footer">
                    <a href="{{ route('admin.FrontUsers') }}">View all Users</a>
                </div>
                @endif
            </div>
        </div>

        <div class="col-md-6 d-flex chartHeight">
            <div class="card card-table flex-fill">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center card-height">
                    <h3 class="card-title mb-0">Users Chart</h3>
                    <div class="from-group">
                        <input type="text" class="form-control" id="UserDateRange" >
                    </div>
                </div>
                <div class="card-body">
                    <div id="UserChart" style="height:100%"></div>
                </div>
            </div>
        </div>

        <!--End Users  -->


        <!-- Vehicle -->
        <div class="col-md-6 d-flex">
            <div class="card card-table flex-fill">
                <div class="card-header">
                    <h3 class="card-title mb-0">Recent Vehicle</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table custom-table table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th>Owner Name</th>
                                    <th>Barcode</th>
                                    <th>Vehicle No.</th>
                                    <th>Mobile</th>
                                    <th>Brand</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($pageData['recent_vehicle']) > 0)
                                @foreach($pageData['recent_vehicle'] as $vehicle)
                                <tr>
                                    <td>{{ ucwords($vehicle->owner_name) }}</td>
                                    <td>{{ $vehicle->barcode }}</td>
                                    <td>{{ $vehicle->vehicle_no }}</td>
                                    <td>{{ $vehicle->mobile_number }}</td>
                                    <td>{{ ucwords($vehicle->VehicleBrand->name ?? "") }}</td>
                                    <td class="text-center"><a class="action_icon view_vehicle" data-id="{{ $vehicle->id }}" title="View"><i class="fa fa-eye"></i></a></td>
                                </tr>
                                @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center">No Data</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                @if(count($pageData['recent_vehicle']) > 0)
                    <div class="card-footer">
                        <a href="{{ route('admin.vehiclesList') }}">View all Vehicles</a>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-md-6 d-flex chartHeight">
            <div class="card card-table flex-fill">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center card-height">
                    <h3 class="card-title mb-0">Vehicles Chart</h3>
                    <div class="from-group">
                        <input type="text" class="form-control" id="VehicleDateRange" >
                    </div>
                </div>
                <div class="card-body">
                    <div id="VehicleChart" style="height:100%"></div>
                </div>
            </div>
        </div>

        <!--End Vehicle  -->

        <!-- Insurance Enquiry -->

        <div class="col-md-6 d-flex">
            <div class="card card-table flex-fill">
                <div class="card-header">
                    <h3 class="card-title mb-0">Recent Insurance Enquiry</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table custom-table table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th>Insurance</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Lead from</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($pageData['recent_insurance']) > 0)
                                @foreach($pageData['recent_insurance'] as $insurance)
                                <tr>
                                    <td>{{ ucwords($insurance->Insurance->name ?? "") }}</td>
                                    <td>{{ $insurance->first_name }} {{ $insurance->last_name }}</td>
                                    <td>{{ $insurance->mobile_number }}</td>
                                    <td>{{ $insurance->adminRole->name ?? ""}}</td>
                                    <td class="text-center"><a class="action_icon view_insurance_equiry" data-id="{{ $insurance->id }}" title="View"><i class="fa fa-eye"></i></a></td>
                                </tr>
                                @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center">No Data</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                @if(count($pageData['recent_insurance']) > 0)
                    <div class="card-footer">
                        <a href="{{ route('admin.ins_enquiry') }}">View all Insurance Enquiry</a>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-md-6 d-flex chartHeight">
            <div class="card card-table flex-fill">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center card-height">
                    <h3 class="card-title mb-0">Insurances Chart</h3>
                    <div class="from-group">
                        <input type="text" class="form-control" id="InsuranceDateRange" >
                    </div>
                </div>
                <div class="card-body">
                    <div id="InsuranceChart" style="height:100%"></div>
                </div>
            </div>
        </div>

        <!-- End Insurance Enquiry -->


    </div>

</div>


<!--Model Modal -->
<div class="modal fade" id="Model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title ModalHeader" id="exampleModalLongTitle"></h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div id="ModalBody">

            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')
    <script rel="preload" src="{{ asset('admin_assets/js/google_charts.js') }}" as="script"></script>
    <script rel="preload" src="{{ asset('admin_assets/js/moment.min.js') }}" as="script"></script>
    <script rel="preload" src="{{ asset('js/daterangepicker.min.js') }}" as="script"></script>
    <script rel="preload" src="{{ asset('admin_assets/js/custom/custom_chart.js') }}" as="script"></script>
    <script rel="preload" src="{{ asset('admin_assets/js/custom/dashboard.js') }}" as="script"></script>
@endsection

