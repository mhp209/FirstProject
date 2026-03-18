@extends('admin.layouts.app')

@section('content')
    <div class="content container-fluid">
        <div>
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
            <h4 class="header-title">
                Admin User Management
            </h4>
            </h4>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card p-3">
                    <div class="mb-2">
                        <div class="row">
                            <div class="col-2 mb-2 float-end float-right">
                                <a href="{{ route('users.create') }}" class="btn btn-primary d-flex">
                                    Add New Admin
                                </a>
                            </div>
                        </div>
                    </div>
                    @include('admin.includes.search')
                    <table id="admin-responsive-datatable" class="table table-centered mb-0 table-responsive w-100"
                        aria-describedby="user_table_info">
                        <thead>
                            <tr>
                                <th width="5%" style="text-align:left">Sr. No.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Created Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script rel="preload" src="{{ asset('admin_assets/js/custom/users.js') }}" as="script"></script>
@endsection

