@extends('front.layout.master')

@section('content')

    <section id="my-vechicle-section">
        <div class="container">

            <div class="container">
                @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-bs-dismiss="alert">&times;</button>
                    <strong>{{ $message }}</strong>
                </div>
                @endif
                @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-bs-dismiss="alert">&times;</button>
                    <strong>{{ $message }} </strong>
                </div>
                @endif
            </div>

            <div class="row">
                <div class="col-lg-12">
                    @include('front.layout.my_account_navbar')
                </div>
                <div class="col-lg-12">
                <div class="user-datelis-wrapper">
                    <div class="row gy-3">
                        <div class="col-lg-4">
                            <div class="add-address-wrapper">
                                <a href="{{ route('add.address')}}">
                                    <span class="material-symbols-outlined">
                                        add
                                    </span>
                                    <h4>Add Address</h4>
                                </a>
                            </div>
                        </div>
                        @if(count($address_list) > 0)
                        @foreach ($address_list as $key=>$address)
                        <div class="col-lg-4">
                            <div class="address-wrapper">
                                <h5>{{ $address->first_name}} {{ $address->last_name}}</h5>
                                <p>{{ $address->add1 }} {{ (!empty($address->add2) ? ', '.$address->add2 : '') }}
                                ,{{ $address->city }} ,{{ $address->state }} ,{{ $address->pincode }}</p>
                                <p>phone number:+91 {{$address->mobile_number}}</p>
                                <div class="btn">
                                    <a href="{{ route('edit.address', $address->id ) }}">edit</a> |
                                    <a class='delete' href="javascript:;" data-toggle="tooltip" data-id="{{ $address->id }}" data-href="{{ url('del-address/'. $address->id) }}">Delete</a>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-lg-4">
                            <div class="address-wrapper">
                                <h5>jaivin patel</h5>
                                <p>92/1124 uday avenue,near nalanda school, Ghatlodia, pavapuri road, Ahmedabad,
                                    Gujarat, 380061,india</p>
                                <p>phone number:+91 95105 32165</p>
                                <div class="btn">
                                    <a href="#">edit</a> |
                                    <a href="#">Set As default</a>
                                </div>
                            </div>
                        </div> --}}
                        @endforeach
                        @else
                        {{-- <p class="text-center">No Address Added</p> --}}
                        @endif

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
