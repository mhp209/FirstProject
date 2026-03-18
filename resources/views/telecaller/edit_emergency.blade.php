@extends('admin.layouts.app')

@section('content')
<div class="content container-fluid">

    <div class="card-header border-bottom text-bg-primary">
        <h5 class="header-title">
            Edit Emergency
        </h5>
    </div>

    <div class="card p-3">
        <div class="container">
            <h1 class="text-center">Caller Details</h1>
            <div class="">
                <form method="post" action="{{ url('admin/emergency/store') }}" data-parsley-validate id="emergency_form">
                    @csrf
                    <input type="hidden" name="id" value="{{ $EmergencyData->id }}">
                    <input type="hidden" name="vehicle_id" value="{{ $EmergencyData->vehicle_id }}">
                    <input type="hidden" name="telecaller_id" value="{{ Auth::guard('admin')->user()->id }}">
                    <input type="hidden" name="vehicle_no" value="{{ $EmergencyData->vehicle_no }}">

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="caller_name" class="form-label">Caller Name <span class="text text-danger">*</span></label>
                                    <input type="caller_name" name="caller_name" class="form-control @error('caller_name') is-invalid @enderror" id="caller_name" value="{{ $EmergencyData->caller_name }}" placeholder="Enter Your Caller Name">
                                    @error('caller_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="caller_number" class="form-label">Caller Number <span class="text text-danger">*</span></label>
                                    <input type="caller_number" name="caller_number" class="form-control @error('caller_number') is-invalid @enderror" id="caller_number" value="{{ $EmergencyData->caller_number }}" placeholder="Enter Your Caller Number">
                                    @error('caller_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="location" class="form-label">Location <span class="text text-danger">*</span></label>
                                    <input type="location" name="location" class="form-control @error('location') is-invalid @enderror" id="location" value="{{ $EmergencyData->location }}" placeholder="Enter Location">
                                    @error('location')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="description" class="form-label">Description <span class="text text-danger">*</span></label>
                                    <textarea name="description" id="editor" cols="100%" rows="5" class="ckeditor">
                                    {{ $EmergencyData->description }}
                                    </textarea>
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <button type="submit" class="btn btn-primary"> Edit Emergency </button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>


        @if(isset($error))
        <div class="card p-3">
            <h4>{{ $error }}</h4>
        </div>
        @endif
    </div>
    <div class="card p-3">
        <div class="container">
            <h1 class="text-center">Call Histories</h1>
            <div class="">
                <table id="table" class="table table-centered mb-0 table-responsive w-100" aria-describedby="product_table_info">
                    <thead>
                        <tr>
                            <th width="5%">Sr. No.</th>
                            <th>Caller Name</th>
                            <th>Details</th>
                            <th>Date</th>
                            <th>Status </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($EmergencyHistories) > 0)
                        @foreach ($EmergencyHistories as $key => $data)
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
        @if(isset($error))
        <div class="card p-3">
            <h4>{{ $error }}</h4>
        </div>
        @endif
    </div>



</div>
@endsection

@section('script')
<script rel="preload" src="{{ asset('admin_assets/js/custom/telecaller.js') }}" as="script"></script>
@endsection
