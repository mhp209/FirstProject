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

        <div class="card-header border-bottom text-bg-primary">
            <h5 class="header-title">
                Barcode Management
            </h5>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card p-3">
                    @if(Auth::guard('admin')->user()->role == 'SUPER_ADMIN' || Auth::guard('admin')->user()->role == 'ADMIN')
                    <div class="mb-2">
                        <div>
                            <a href="{{ route('barcode.create') }}" class="float-end">
                                <button class="btn btn-primary d-flex" title="Add-user"><i
                                    class="ri-user-add-fill me-1"></i> Upload Barcode </button>
                            </a>
                        </div>
                        <div class="float-right">
                            <form action="" method="GET">
                                <div class="input-group">
                                  <div class="form-outline" data-mdb-input-init>
                                    <input type="search" name="filter" value="{{ $filter }}" id="filter" class="form-control" />
                                  </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    @endif
                    <table id="table" class="table table-centered mb-0"
                        aria-describedby="user_table_info">
                        <thead>
                            <tr>
                                <th width="10%">Sr. No.</th>
                                <th width="10%">Barcode</th>
                                <th width="10%">Customer Name</th>
                                <th width="10%">Seller Name</th>
                                <th width="10%">Uploaded By</th>
                                <th width="5%">Is Product?</th>
                                <th width="10%">Status</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                                @if(count($barcode_list) > 0)
                                    @foreach ($barcode_list as $key => $data)
                                    <tr>
                                        <td><?= $key+1 ?></td>
                                        <td>{{ $data->barcode }}</td>
                                        <td>{{ $data->customer_name }}</td>
                                        <td>{{ ($data->seller_id) ? getadminName($data->seller_id) : '' }}</td>
                                        <td>{{ getadminName($data->uploaded_by) }}</td>
                                        <td>
                                        	@if($data->is_online_product == 1)
                                        		YES
                                        	@else
                                        		NO
                                        	@endif
                                        </td>
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
                                        <td colspan="2">

                                        </td>
                                    </tr>
                                @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" style="text-align: center;">No Data</td>
                                    </tr>
                                @endif

                        </tbody>
                    </table>

                    <div>
                        {{ $barcode_list->appends(['filter' => $filter])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script rel="preload" src="{{ asset('admin_assets/js/custom/barcode.js') }}" as="script"></script>
@endsection
