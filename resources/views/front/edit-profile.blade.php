@extends('front.layout.master')

@section('content')


<section class="container">
    <h2 class="add-line my-5">Update Profile</h2>

    <div class="container">
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-bs-dismiss="alert"><i class="fs-6 far fa-times-circle"></i></button>
            <strong>{{ $message }}</strong>
        </div>
        @endif
        @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-bs-dismiss="alert"><i class="fs-6 far fa-times-circle"></i></button>
            <strong>{{ $message }} </strong>
        </div>
        @endif
    </div>

    <div class="row p-4">
        <div class="col-lg-12 px-4">
          <form method="POST" action="{{ route('user.update') }}" id="frm_register">
          @csrf
          <input type="hidden" name="id" value="{{ Auth::user()->id }}">
          <div class="shadow">
            <div class="row p-4">
              <div class="col-lg-3 mt-1">
                <p class="fw-bold">First Name : </p>
              </div>
              <div class="col-lg-9">
                  <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ Auth::user()->first_name }}" placeholder="Enter Your First Name" autocomplete="first_name" autofocus>
                  @error('first_name')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                   @enderror
              </div>
              <div class="col-lg-3 mt-1">
                <p class="fw-bold">Last Name: </p>
              </div>
              <div class="col-lg-9">
               <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ Auth::user()->last_name }}" placeholder="Enter Your Last Name" autocomplete="last_name" autofocus>
                  @error('last_name')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                   @enderror
              </div>
              <div class="col-lg-3 mt-1">
                <p class="fw-bold">Email : </p>
              </div>
              <div class="col-lg-9">
                 <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ Auth::user()->email }}" placeholder="Enter Your Email" autocomplete="email">
                  @error('email')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>

              <div class="col-lg-9">
                  <button type="submit" class="btn btn-success">Update</button>
              </div>
              <!-- <div class="col-lg-3">
                <p class="fw-bold">Vehical Picture : </p>
              </div>
              <div class="col-lg-9">
               <div class="mb-3">
                <label for="formFile" class="form-label">Front</label>
                <input class="form-control" type="file" id="formFile">
                </div>
              </div>
              <div class="col-lg-3">
                <p class="fw-bold">Vehical Picture : </p>
              </div>
              <div class="col-lg-9">
               <div class="mb-3">
                <label for="formFile" class="form-label">Back</label>
                <input class="form-control" type="file" id="formFile">
                </div>
              </div> -->

            </div>
          </div>
          </form>
        </div>
    </div>

</section>


@endsection
