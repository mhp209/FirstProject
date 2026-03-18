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
            Front User List
        </h4>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card p-3">

                @include('admin.includes.search')

                <table id="users-responsive-datatable" class="table table-centered mb-0 table-responsive w-100"
                    aria-describedby="user_table_info">
                    <thead>
                        <tr>
                            <th width="5%" style="text-align:center">Sr. No.</th>
                            <th>User Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Date-time</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection('content')

@section('script')
    <script rel="preload" src="{{ asset('admin_assets/js/custom/users.js') }}" as="script"></script>
@endsection
