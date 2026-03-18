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
            Add New User
        </h5>
    </div>
    <div class="card p-3">
        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <form method="post" action="{{ route('users.store') }}" data-parsley-validate id="users_validate" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        @include('admin.users.form')
                    </form>
                </div>
                <!-- end row -->
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script rel="preload" src="{{ asset('admin_assets/js/custom/users.js') }}" as="script"></script>
@endsection
