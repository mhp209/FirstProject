@extends('front.layout.master')

@section('content')
@php
if($title == "Add")
$actionUrl = route('store.address');
else
$actionUrl = route('update.address');
@endphp

<script>
    var model_id = '<?= $addressData->model ?>';
    var title = '<?= $title ?>';
    console.log(title);
    if (title == "Add") {
        var actionUrl = "{{ route('store.address') }}";
    }
    if (title == "Update") {
        var actionUrl = "{{ route('update.address') }}";
    }
    console.log(actionUrl);
</script>

<section id="add-address-form">
    <div class="container">
        <div class="back-btn">
            <a href="{{ route('address') }}" class="gap-2">
                <span class="material-symbols-outlined">
                    arrow_back
                </span>
                back
            </a>
        </div>
        <div class="row gy-3">
            <div class="col-lg-12">
                <div class="add-address-form ">
                    <div class="col-lg-8">
                        <form id="address_frm" method="post" action="{{ $actionUrl }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            @if($title == "Update")
                            <input type="hidden" name="id" value="{{ $addressData->id }}">
                            @endif
                            <div class="form-wrapper">
                                <h2 class="text-center ">{{ $title }} Address</h2>
                                <div class="row">
                                    <div class="col-lg-6 first-name">
                                        <label class="justify-content-center align-items-center ">
                                            <span class="material-symbols-outlined">
                                                person
                                            </span>
                                        </label>
                                        <input type="text" name="first_name" id="first_name" value="{{ $addressData->first_name }}" class="@error('name') is-invalid @enderror" placeholder="First Name">
                                        @error('first_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 first-name">
                                        <label class="justify-content-center align-items-center ">
                                            <span class="material-symbols-outlined">
                                                person
                                            </span>
                                        </label>
                                        <input type="text" name="last_name" id="last_name" value="{{ $addressData->last_name }}" class="@error('last_name') is-invalid @enderror" placeholder="Last Name">
                                        @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 mobile-number">
                                        <label class="justify-content-center align-items-center ">
                                            <span class="material-symbols-outlined">
                                                call
                                            </span>
                                        </label>
                                        <input type="number" name="mobile_number" id="mobile_number" value="{{ $addressData->mobile_number }}" class="@error('mobile_number') is-invalid @enderror" placeholder="Mobile Number">
                                        @error('mobile_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 email-wrapper">
                                        <label class="justify-content-center align-items-center ">
                                            <span class="material-symbols-outlined">
                                                mail
                                            </span>
                                        </label>
                                        <input type="text" name="email" id="email" value="{{ $addressData->email }}" class="@error('email') is-invalid @enderror" placeholder="Email">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 email-wrapper">
                                        <label class="justify-content-center align-items-center ">
                                            <span class="material-symbols-outlined">
                                                home
                                            </span>
                                        </label>
                                        <input type="text" name="add1" id="add1" value="{{ $addressData->add1 }}" placeholder="Address 1">
                                        @error('add1')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 email-wrapper">
                                        <label class="justify-content-center align-items-center ">
                                            <span class="material-symbols-outlined">
                                                home
                                            </span>
                                        </label>
                                        <input type="text" name="add2" id="add2" value="{{ $addressData->add2 }}" placeholder="Address 2">
                                    </div>
                                    <div class="col-lg-6 mobile-number">
                                        <label class="justify-content-center align-items-center ">
                                            <span class="material-symbols-outlined">
                                                pin_drop
                                            </span>
                                        </label>
                                        <input type="number" min="0" name="pincode" id="pincode" value="{{ $addressData->pincode }}" placeholder="Pincode">
                                        @error('pincode')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 email-wrapper">
                                        <label class="justify-content-center align-items-center ">
                                            <span class="material-symbols-outlined">
                                                location_city
                                            </span>
                                        </label>
                                        <input type="text" name="city" id="city" placeholder="City" value="{{ $addressData->city }}">
                                        @error('city')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 state-wrapper">
                                        <select name="state" id="state" class="form-select">
                                            <option value="">Select a State</option>
                                            <option {{ ($addressData->state == 'Gujarat')? 'selected' : ''}}>Gujarat</option>
                                            <option {{ ($addressData->state == 'Delhi')? 'selected' : ''}}>Delhi</option>
                                            <option {{ ($addressData->state == 'Haryana')? 'selected' : ''}}>Haryana</option>
                                        </select>
                                        @error('state')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="same-address" name="is_default" value='1' {{ ($addressData->is_default == '1')? 'checked' : ''}}>
                                        <label class="custom-control-label" for="same-address">Make this my default
                                            Address</label>
                                    </div>
                                    <div class="sign-up text-center">
                                        <a href="#"><button type="submit"> {{$title}} Address </button></a>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                    <div class="col-lg-4 my-auto ">
                        <div class="images">
                            <img src="{{ asset('front_assets/images/login-form.jpg') }}" alt="" class="img-fluid ">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    window.addEventListener('load', function() {
        loadJS("{{ asset('front_assets/js/jquery.validate.min.js') }}");
        loadJS("{{ asset('front_assets/custom_js/address.js') }}");
    });
</script>
@endsection
