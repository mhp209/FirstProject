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
                    <a class="collapsed" data-bs-toggle="collapse" href="#collapseOne" aria-expanded="false">Add Banner</a>
                </h4>
            </div>
            <div id="collapseOne" class="card-collapse collapse {{ ($banner_Obj->id) ? 'show' : '' }}">
                <div class="card-body">
                    <form method="post" action="{{ url('admin/banner/store') }}" data-parsley-validate id="banner_validate" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="uid" value="{{ $banner_Obj->id }}">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="name" class="form-label">Banner Name <span class="text text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ $banner_Obj->name ? $banner_Obj->name : old('name') }}" placeholder="Enter Your Banner Name">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="image" class="form-label">Banner Image <span class="text text-danger">*</span></label>
                                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                                    @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <a href="{{ url('admin/banner') }}" class="btn btn-danger mt-2">Cancel</a>
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
        <h4 class="mb-0">Banner List</h4>
        <hr>
        <table id="banners-responsive-datatable" class="table table-centered mb-0 table-responsive" aria-describedby="user_table_info">
            <thead>
                <tr>
                    <th width="10%">Sr. No.</th>
                    <th width="20%">Name</th>
                    <th width="15%">Image</th>
                    <th width="10%">Status</th>
                    <th width="10%">Action</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($banners))
                @foreach ($banners as $key => $data)
                <tr>
                    <td><?= $key + 1 ?></td>
                    <td>{{ $data->name }}</td>
                    <td>
                        @if($data->image)
                        <img src="{{BASE_URL.'public/uploads/BannerImage/'.$data->image}}" height="50px" width="60px">
                        @else
                        <img src="{{ asset('public/admin_assets/img/placeholder.jpg') }}" height="50px" width="60px">
                        @endif
                    </td>
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
                        <a class="action_icon" href="{{ url('admin/banner/'. $data->id) }}" title="Edit"><i class="fa fa-pencil m-r-5"></i></a>
                        <a href="javascript:;" data-toggle="tooltip" data-id="{{ $data->id }}" data-href="{{ route('admin.banner.delete' , $data->id ) }}" class="action_icon ml-1 delete" title="Delete"><i class="fa fa-trash-o m-r-5"></i></a>
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
@endsection
@section('script')
<script rel="preload" src="{{ asset('admin_assets/js/custom/banner.js') }}" as="script"></script>
@endsection
