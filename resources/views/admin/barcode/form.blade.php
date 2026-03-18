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
                    <a class="collapsed" data-bs-toggle="collapse" href="#collapseOne" aria-expanded="false">Assign Barcode</a>
                </h4>
            </div>
            <div id="collapseOne" class="card-collapse collapse">
                <div class="card-body">
                    <form method="post" action="{{ route('barcode.store') }}" data-parsley-validate id="barcode_frm" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="total_barcode" id='total_barcode' value="" />

                        <div class="row">

                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    <label for="first_name" class="form-label">Assign User <span class="text text-danger">*</span></label>
                                    <select name="assign_to" id="assign_to" class="form-control @error('assign_to') is-invalid @enderror">
                                        <option value="">Select a user</option>
                                        @foreach ($user_list as $user)
                                        <option value="{{ $user->id }}"data-role="{{ $user->role }}">{{ $user->name.' - '.$user->role }}</option>
                                        @endforeach
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
                                    <label for="wheeler_type" class="form-label">Wheeler Type </label>
                                    <select name="wheeler_type" id="wheeler_type" class="form-control">
                                        <option value="2 Wheeler">2 Wheeler</option>
                                        <option value="4 Wheeler">4 Wheeler</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3" id="priceInput" style="display: none;">
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
                            <div class="col-md-3 mb-3">
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
                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    <label for="total_count" class="form-label">Total count <span class="text text-danger">*</span></label>
                                    <input type="number" name="count" id="count" min="1" class="form-control @error('count') is-invalid @enderror" placeholder="Total count">
                                    @error('count')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    <p id="barcode_msg" class="text-danger" style="display: none;"></p>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <a href="{{ url('admin/barcode') }}" class="btn btn-danger mt-2">Cancel</a>
                                    <button class="btn btn-primary mr-1 mt-2" id="assign_btn">
                                        <i class="ri-user-add-fill me-1"></i> Assign
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
        <h3 class="mb-0">Assign Barcode List</h3>
        <hr>

        @include('admin.includes.search')

        <table id="assign_barcode" class="table table-centered mb-0 table-responsive w-100" aria-describedby="user_table_info">
            <thead>
                <tr>
                    <th width="5%">Sr. No.</th>
                    <th>Assign To</th>
                    <th>Wheeler Type</th>
                    <th>Count</th>
                    <th>Date</th>
                    <th>Download</th>
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
<script rel="preload" src="{{ asset('admin_assets/js/custom/assign_barcode.js') }}" as="script"></script>
@endsection
