@extends('admin.layouts.app')

@section('content')
<div class="content container-fluid">

    <div class="card-header border-bottom text-bg-primary">
        <h5 class="header-title">
           Add Emergency
        </h5>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card p-3">
                <div class="container">
                    <h1 class="text-center">Emergency Call Details</h1>
                    <div class="">
                        <form method="post" action="{{ route('store.call-emergency') }}" data-parsley-validate id="call_emergency_form">
                            @csrf
                            <input type="hidden" name="id" value="{{$Emergency->id}}">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                            <label for="location" class="form-label">Status <span class="text text-danger">*</span></label>
                                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                                <option value="">Select a Status</option>
                                                <option value="1">Active</option>
                                                <option value="0">InActive</option>
                                            </select>
                                            @error('status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="description" class="form-label">Details <span class="text text-danger">*</span></label>
                                            <textarea name="details" id="editor" cols="90%" rows="10" class="ckeditor">
                                            </textarea>
                                            @error('details')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <a href="{{ url('admin/emergency') }}" class="btn btn-danger">Cancel</a>
                                        <button type="submit" class="btn btn-primary"> Save Call </button>
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
                                @if(count($EmergencyData) > 0)
                                @foreach ($EmergencyData as $key => $data)
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
    </div>
</div>
@endsection

@section('script')
<script rel="preload" src="{{ asset('admin_assets/js/custom/telecaller.js') }}" as="script"></script>
@endsection
