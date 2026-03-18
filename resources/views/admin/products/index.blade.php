@extends('admin.layouts.app')

@section('content')
    <div class="content container-fluid">
        <div class="row">
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
                Product Management
            </h5>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card p-3">
                    <div class="mb-2">
                        <div>
                            <a href="{{ route('products.create') }}" class="float-end">
                                <button class="btn btn-primary d-flex" title="Add-user"><i
                                    class="ri-user-add-fill me-1"></i> Add New Product</button>
                            </a>
                        </div>
                    </div>
                    <table id="products-responsive-datatable" class="table table-centered mb-0"
                        aria-describedby="product_table_info">
                        <thead>
                            <tr>
                                <th width="10%">Sr. No.</th>
                                <th width="20%">Product Name</th>
                                <th width="15%">Description</th>
                                <th width="10%">Price</th>
                                <th width="10%">Image</th>
                                <th width="10%">Status</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($products))
                                @foreach ($products as $key => $data)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td>{!! Str::limit(nl2br($data->desc), 30) !!}</td>
                                        <td>₹ {{ $data->price }}</td>
                                        <td>
                                            @if($data->product_image)
                                                @foreach ($data->product_image as $key1 => $item)
                                                    @if($key1 == '0')
                                                        <img src="{{BASE_URL.'public/uploads/ProductImage/'.$item->image}}" height="50px" width="60px">
                                                    @endif
                                                @endforeach
                                            @else
                                                <img src="{{ asset('admin_assets/img/logo.png') }}" height="50px" width="60px">
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
                                            <a class="action_icon" href="{{ route('products.edit', $data->id ) }}"><i class="fa fa-pencil"></i></a>
                                            <a href="javascript:;" data-toggle="tooltip" data-id="{{ $data->id }}"
                                                data-href="{{ url('admin/products-del/'. $data->id) }}"
                                                class="action_icon ml-1 delete"><i
                                                    class="fa fa-trash-o"></i></a>
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
@endsection
@section('script')
    <script rel="preload" src="{{ asset('admin_assets/js/custom/product.js') }}" as="script"></script>
@endsection