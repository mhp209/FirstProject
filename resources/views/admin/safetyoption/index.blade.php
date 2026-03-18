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
            Safety Management
        </h5>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card p-3">
                <div class="card-header border-bottom text-bg-primary">
                    <h5 class="header-title">
                        Add Reason
                    </h5>
                </div>
                <div class="card p-3 mb-3">
                    <form method="post" action="{{ url('admin/safety-option/store') }}" data-parsley-validate id="safety_option_validate">
                        @csrf
                        <input type="hidden" name="sid" value="{{ $safety_optionObj->id }}">
                        <div class="row">
                            <div class="col-md-5 mb-3">
                                <div class="form-group">
                                    <label for="reason_option" class="form-label">Reason <span class="text text-danger">*</span></label>
                                    <input type="text" name="reason_option" class="form-control @error('reason_option') is-invalid @enderror" id="reason_option" value="{{ $safety_optionObj->reason_option ? $safety_optionObj->reason_option : old('reason_option') }}" placeholder="Enter Your Reason">
                                    @error('reason_option')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-5 mb-3">
                                <div class="form-group">
                                    <label for="alias" class="form-label">Alias <span class="text text-danger">*</span></label>
                                    <input type="text" name="alias" class="form-control @error('alias') is-invalid @enderror" id="alias" value="{{ $safety_optionObj->alias ? $safety_optionObj->alias : old('alias') }}" placeholder="Enter Your Reason Alias">
                                    @error('alias')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="message" class="form-label">Message</label>
                                    <textarea name="message" cols="5" rows="5" class="form-control">{{ $safety_optionObj->message ? $safety_optionObj->message : old('message') }}</textarea>
                                    @error('message')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <a href="{{ url('admin/safety-option') }}" class="btn btn-danger mt-2">Cancel</a>
                                    <button class="btn btn-primary mr-1 mt-2">
                                        <i class="ri-user-add-fill me-1"></i> Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card p-3">
                    <table id="safety-option-responsive-datatable" class="table table-centered mb-0" aria-describedby="user_table_info">
                        <thead>
                            <tr>
                                <th width="10%">Sr. No.</th>
                                <th width="20%">Reason</th>
                                <th width="15%">Alias</th>
                                <th width="15%">Message</th>
                                <th width="10%">Status</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($safety_option) > 0)
                                @foreach ($safety_option as $key => $data)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $data->reason_option }}</td>
                                        <td>{{ $data->alias }}</td>
                                        <td>{!! Str::limit(nl2br($data->message), 30) !!}</td>

                                        <td>
                                            <div class="dropdown action-label">
                                                @if ($data->status == '0')
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
                                        <td colspan="2">
                                            <a class="action_icon" href="javascript:;" data-id="{{ $data->id }}" id="reason_data_info" data-toggle="modal" data-target="#reasonModal"><i class="fa fa-eye mr-2"></i></a>
                                            <a class="action_icon" href="{{ url('admin/safety-option/' .$data->id ) }}" title="Edit"><i class="fa fa-pencil m-r-5"></i></a>
                                            <a href="javascript:;" data-toggle="tooltip" data-id="'.$data->id.'" data-href="{{ url('admin/safety-del/' . $data->id ) }}" class="action_icon ml-1 delete" title="Delete"><i class="fa fa-trash-o m-r-5"></i></a>
                                        </td>
                                    @endforeach
                                @else
                                    <td colspan="3" style="text-align: center;">No Data</td>
                                @endif
                                    </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="reasonModal" tabindex="-1" aria-labelledby="reasonModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reasonModalLabel">Reason Details</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="messageDataContainer">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script rel="preload" src="{{ asset('admin_assets/js/custom/safety_option.js') }}" as="script"></script>
@endsection
