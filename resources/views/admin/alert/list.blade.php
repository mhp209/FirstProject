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
                SMS Alert Management
            </h5>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card p-3">

                    @include('admin.includes.search')

                    <table id="datatable" class="table table-centered mb-0 table-responsive w-100"
                    aria-describedby="datatable">
                        <thead>
                            <tr>
                                <th width="5%">Sr. No.</th>
                                <th>Vehicle No</th>
                                <th>Mobile</th>
                                <th>Message Type</th>
                                <th>Date</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

<!--Model Modal -->
<div class="modal fade" id="Model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title ModalHeader" id="exampleModalLongTitle"></h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div id="ModalBody">

            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@endsection
@section('script')
    <script rel="preload" src="{{ asset('admin_assets/js/custom/alert.js') }}" as="script"></script>
@endsection
