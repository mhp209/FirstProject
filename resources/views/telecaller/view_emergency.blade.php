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

        <h1 class="text-center">Emergency Details</h1>
        <div class="">
            <div class="col-md-12">
                <p><strong>Caller Name: </strong> {{ $Emergency->caller_name }}</p>
                <p><strong>Caller Number: </strong> {{ $Emergency->caller_number }}</p>
                <p><strong>Location : </strong> {{ $Emergency->location }}</p>
                <p><strong>Description: </strong> <?= nl2br($Emergency->description) ?></p>
            </div>

        </div>

        <div class="container">
            <h1 class="text-center">Call Histories</h1>
            <div class="">
                <table id="table" class="table table-centered mb-0" aria-describedby="product_table_info">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Caller Name</th>
                            <th>Details</th>
                            <th>Date</th>
                            <th>Status </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($EmergencyHistoriesData) > 0)
                        @foreach ($EmergencyHistoriesData as $key => $data)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ ucwords($data->Emergency->caller_name) }}</td>
                            <td>{{ $data->details }}</td>
                            <td>{{ $data->created_at }}</td>
                            <td>
                                <div class="dropdown action-label">
                                    @if($data->status == '0')
                                    <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="javascript:;" data-id="{{ $data->id }}" value="1"><i class="fa fa-dot-circle-o text-danger"></i> Inactive</a>
                                    @else
                                    <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="javascript:;" data-id="{{ $data->id }}" value="0"><i class="fa fa-dot-circle-o text-success"></i> Active</a>
                                    @endif
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item status" href="javascript:;" data-id="{{ $data->id }}" value="1"><i class="fa fa-dot-circle-o text-success"></i> Active</a>
                                        <a class="dropdown-item status" href="javascript:;" data-id="{{ $data->id }}" value="0"><i class="fa fa-dot-circle-o text-danger"></i> Inactive</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="6" style="text-align: center;">No Data</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@section('script')
    <script rel="preload" src="{{ asset('admin_assets/js/custom/telecaller.js') }}" as="script"></script>
@endsection
