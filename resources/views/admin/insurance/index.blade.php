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

    <div class="faq-card">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    <a class="collapsed" data-bs-toggle="collapse" href="#collapseOne" aria-expanded="false">Add Insurance</a>
                </h4>
            </div>
            <div id="collapseOne" class="card-collapse collapse {{ ($insurance_Obj->id) ? 'show' : '' }}">
                <div class="card-body">
                    <form method="post" action="{{ url('admin/insurance/store') }}" data-parsley-validate id="insurance_validate" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="uid" value="{{ $insurance_Obj->id }}">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="name" class="form-label"> Name <span class="text text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ $insurance_Obj->name ? $insurance_Obj->name : old('name') }}" placeholder="Enter Your insurance Name">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="alias" class="form-label">Alias <span class="text text-danger">*</span></label>
                                    <input type="text" name="alias" class="form-control @error('alias') is-invalid @enderror" id="alias" value="{{ $insurance_Obj->alias ? $insurance_Obj->alias : old('alias') }}" placeholder="Enter Your Alias">
                                    @error('alias')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="image" class="form-label" > Image <span class="text text-danger">*</span></label>
                                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                                    @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="order_by" class="form-label">Order By </label>
                                    <input type="number" name="order_by" class="form-control @error('order_by') is-invalid @enderror" id="order_by" value="{{ $insurance_Obj->order_by ? $insurance_Obj->order_by : old('order_by') }}" placeholder="Enter Your Order By">
                                    @error('order_by')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <a href="{{ url('admin/insurance') }}" class="btn btn-danger mt-2">Cancel</a>
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
    <div class="card p-3">
        <h4 class="mb-0">Insurance List</h4>
        <hr>
        <table id="insurance-responsive-datatable" class="table table-centered mb-0 table-responsive w-100" aria-describedby="user_table_info">
            <thead>
                <tr>
                    <th width="5%">Sr. No.</th>
                    <th>Name</th>
                    <th>Alias</th>
                    <th>Image</th>
                    <th>Order By</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($insurance))
                    @foreach ($insurance as $key => $data)
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td>{{ ucwords($data->name) }}</td>
                            <td>{{ $data->alias }}</td>
                            <td>
                                @if($data->image)
                                   <img src="{{BASE_URL.'public/uploads/InsuranceImage/'.$data->image}}" height="50px" width="60px">
                                @else
                                    <img src="{{ asset('public/admin_assets/img/placeholder.jpg') }}" height="50px" width="60px">
                                @endif
                            </td>
                            <td>{{$data->order_by}}</td>
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
                                <a class="action_icon" href="{{ url('admin/insurance/'. $data->id) }}" title="Edit"><i class="fa fa-pencil m-r-5"></i></a>
                                <a href="javascript:;" data-bs-toggle="tooltip" data-id="{{ $data->id }}" data-href="{{ route('admin.insurance.delete' , $data->id ) }}" class="action_icon ml-1 delete" title="Delete"><i class="fa fa-trash-o m-r-5"></i></a>
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
@endsection
@section('script')
    <script rel="preload" src="{{ asset('admin_assets/js/custom/insurance.js') }}" as="script"></script>
@endsection
