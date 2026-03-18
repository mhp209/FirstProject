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
        <h4 class="header-title">
            Reassign Barcode
        </h4>
    </div>
    <div class="card p-3">
        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <form method="post" action="" data-parsley-validate id="barcode_gen" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
						    <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="barcode" class="form-label">Type <span class="text text-danger">*</span></label>
                                    <select name="type" id="type" class="form-control @error('type') is-invalid @enderror">
                                    <option value="">Select a user</option>
                                        @foreach ($user_list as $user)
                                        <option value="{{ $user->id }}">{{ $user->name.' - '.$user->role }}</option>
                                        @endforeach
                                    </select>
                                    @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
						    </div>
                            @if($role === 'FRANCHISE_PARTNER')
                            <div class="col-md-3 mb-3" id="priceInput">
                                <div class="form-group">
                                    <label for="price" class="form-label">Price <span class="text text-danger">*</span></label>
                                    <input type="number" name="price" id="price" min="1" class="form-control @error('price') is-invalid @enderror" placeholder="Price">
                                    @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            @endif
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="last_name" class="form-label">Status <span class="text text-danger">*</span></label>
                                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                        <option value="">Select a status</option>
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
						            <button class="btn btn-primary mr-1 mt-2" id="updateBtn">
						                Assign Barcode
						            </button>
						            <a href="{{ route('barcode') }}" class="btn btn-danger mr-1 mt-2">
						                Back
                                    </a>
						        </div>
						    </div>
						</div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card p-3">
        <h3 class="mb-0">Reassign Barcode List</h3>
        <hr>

        <!-- @include('admin.includes.search') -->

        <table id="datatable" class="table table-centered mb-0 table-responsive w-100" aria-describedby="user_table_info">
            <thead>
                <tr>
                    <th width="5%">Checkbox</th>
                    <th>Barcode</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <div>
        </div>
    </div>
</div>


@endsection


@section('script')
<script>
    var code = '{{ Request::segment(4) }}';
</script>
<script rel="preload" src="{{ asset('admin_assets/js/custom/reassign_barcode.js') }}" as="script"></script>
@endsection
