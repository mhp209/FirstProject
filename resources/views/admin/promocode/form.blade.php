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

    <div class="faq-card">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    <a class="collapsed" data-bs-toggle="collapse" href="#collapseOne" aria-expanded="false">Add Promocode</a>
                </h4>
            </div>
            <div id="collapseOne" class="card-collapse collapse {{ ($promocode_Obj->id) ? 'show' : '' }}">
                <div class="card-body">
                    <form method="post" action="{{ route('store.promocode') }}" data-parsley-validate id="promocode_form" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" id="id" value="{{ $promocode_Obj->id }}">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    <label for="barcode" class="form-label">Promocode Type <span class="text text-danger">*</span></label>
                                    <select name="assign_for" id="assign_for" class="form-control @error('assign_for') is-invalid @enderror">
                                        <option value="">Select a type</option>
                                        <option value="web" {{ $promocode_Obj->assign_for == 'web' ? 'selected' : '' }}>Web</option>
                                        <option value="seller" {{ $promocode_Obj->assign_for == 'seller' ? 'selected' : '' }}>Seller</option>
                                        <option value="franchise" {{ $promocode_Obj->assign_for == 'franchise' ? 'selected' : '' }}>Franchise</option>
                                    </select>
                                    @error('assign_for')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3 mb-3" id="assignPromocode" style="display: none;">
                                <div class="form-group">
                                    <label for="barcode" class="form-label">Assign To <span class="text text-danger">*</span></label>
                                    <select name="assign_to" id="assign_to" class="form-control @error('assign_to') is-invalid @enderror">
                                        <option value="">Select a Assign To</option>
                                    </select>
                                    @error('assign_to')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    <label for="code" class="form-label">Code <span class="text text-danger">*</span></label>
                                    <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" id="code" value="{{ $promocode_Obj->code ? $promocode_Obj->code : old('name') }}" placeholder="Enter Code">
                                    @error('code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    <label for="last_name" class="form-label">Status <span class="text text-danger">*</span></label>
                                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                        <option value="">Select a status</option>
                                        <option value="1" {{ $promocode_Obj->status == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $promocode_Obj->status == '0' ? 'selected' : '' }}>InActive</option>
                                    </select>
                                    @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    <label for="minimum_type" class="form-label">Minimum Type <span class="text text-danger">*</span></label>
                                    <select name="minimum_type" id="minimum_type" class="form-control @error('minimum_type') is-invalid @enderror">
                                        <option value="">Select a type</option>
                                        <option value="quantity" {{ $promocode_Obj->minimum_type == 'quantity' ? 'selected' : '' }}>Quantity</option>
                                        <option value="flat" {{ $promocode_Obj->minimum_type == 'flat' ? 'selected' : '' }}>Amount(Flat)</option>
                                    </select>
                                    @error('minimum_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    <label for="minimum_value" class="form-label">Minimum Value <span class="text text-danger">*</span></label>
                                    <input type="number" name="minimum_value" id="minimum_value" class="form-control @error('minimum_value') is-invalid @enderror" value="{{ $promocode_Obj->minimum_value ? $promocode_Obj->minimum_value : old('minimum_value') }}" placeholder="Enter minimum value">
                                    @error('minimum_value')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    <label for="discount" class="form-label">Discount <span class="text text-danger">*</span></label>
                                    <select name="discount_type" id="discount_type" class="form-control @error('discount_type') is-invalid @enderror">
                                        <option value="">Select a discount</option>
                                        <option value="per" {{ $promocode_Obj->discount_type == 'per' ? 'selected' : '' }}>Percentage</option>
                                        <option value="flat" {{ $promocode_Obj->discount_type == 'flat' ? 'selected' : '' }}>Amount(Flat)</option>
                                    </select>
                                    @error('discount_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    <label for="discount_value" class="form-label">Discount Value <span class="text text-danger">*</span></label>
                                    <select name="discount_per" id="discount_value_per" class="form-control @error('discount_per') is-invalid @enderror" style="display: none;">
                                        @for ($i = 1; $i <= 100; $i++) <option value="{{ $i }}" {{ ($promocode_Obj->discount_per == $i) ? 'selected' : ''}}>{{ $i }} %</option>
                                            @endfor
                                    </select>
                                    <input type="number" name="discount_flat" id="discount_value_flat" class="form-control @error('discount_flat') is-invalid @enderror" value="{{ $promocode_Obj->discount_flat ? $promocode_Obj->discount_flat : old('discount_flat') }}" placeholder="Enter Type Value">
                                    <!-- @error('discount_flat')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror -->
                                </div>
                            </div>

                            <div class="col-md-8 mb-3">
                                <div class="form-group">
                                    <label for="description" class="form-label">Description <span class="text text-danger">*</span></label>
                                    <input type="text" name="description" id="description" class="form-control @error('description') is-invalid @enderror" value="{{ $promocode_Obj->description ? $promocode_Obj->description : old('description') }}" placeholder="Enter Description">
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <button class="btn btn-primary mr-1 mt-2" id="downloadAndRedirect">
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
        <h4 class="mb-0">Promocode List</h4>
        <hr>
        <table id="promocode-responsive-datatable" class="table table-centered mb-0 table-responsive" aria-describedby="user_table_info">
            <thead>
                <tr>
                    <th>Sr. No.</th>
                    <th>Assign For</th>
                    <th>Assign To</th>
                    <th>Code</th>
                    <th>Min Type</th>
                    <th>Min Value</th>
                    <th>Disc Type</th>
                    <th>Disc Value</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($promocode))
                @foreach ($promocode as $key => $data)
                <tr>
                    <td><?= $key + 1 ?></td>
                    <td>{{ ucfirst($data->assign_for) }}</td>
                    <td>{{ ucwords($data->adminRole->name ?? "") }} </td>
                    <td>{{ $data->code }}</td>
                    <td>{{ $data->minimum_type }}</td>
                    <td>{{ $data->minimum_value }}</td>
                    <td>{{ $data->discount_type }}</td>
                    @if ($data->discount_type == 'flat')
                    <td>{{ $data->discount_flat }}</td>
                    @else
                    <td>{{ $data->discount_per }} %</td>
                    @endif
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
                        <a class="action_icon" href="{{ url('admin/promocode/'. $data->id) }}" title="Edit"><i class="fa fa-pencil m-r-5"></i></a>
                        <a href="javascript:;" data-bs-toggle="tooltip" data-id="{{ $data->id }}" data-href="{{ route('promocode.delete' , $data->id ) }}" class="action_icon ml-1 delete" title="Delete"><i class="fa fa-trash-o m-r-5"></i></a>
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
<script>
    var assign_to = '{{ $promocode_Obj->assign_to }}';
</script>
<script rel="preload" src="{{ asset('admin_assets/js/custom/promocode.js') }}" as="script"></script>

@endsection
