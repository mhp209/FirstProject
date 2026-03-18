@extends('front.layout.master')

@section('css')

@endsection
@section('content')
<section id="about-us-banner">
    <div class="container ">
        <div class="section-title text-center ">
            <h1>RS Safety Tag</h1>
        </div>
</section>

<section id="product-details-wrapper">
    <div class="container">
        <div class="row gy-3">
            <div class="col-lg-4 my-auto ">
                <div class="images" data-aos="fade-right" data-aos-duration="1500">
                    <img src="{{ asset('front_assets/images/RS-Safety-Tag.png') }}" alt="" class="img-fluid" width="75%">
                </div>
            </div>
            <div class="col-lg-8">
                <div class="row gy-3">
                    <div class="col-lg-5">
                        <div class="title">
                            <h4>RS Safety Tag </h4>
                        </div>
                        <div class="price">
                            <h3>₹ {{ RS_SAFETY_PRICE }}</h3>
                        </div>
                        <form id="cart_frm" method="post" action="{{ route('add-to-cart') }}">
                            @csrf
                            <div class="select-vehicle-opt">
                                <select name="wheeler_type" id="wheeler_type" class="form-select">
                                    <option value="2 Wheeler">2 Wheeler</option>
                                    <option value="4 Wheeler">4 Wheeler</option>
                                </select>

                            </div>
                            <div class="quantity-wrapper">
                                <button class="btn-one" type="button" id="minus-btn" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">-</button>
                                <input type="number" min="1" id="quantity-input" class="text-center" name='quantity' value="1">
                                <button class="btn-two" type="button" id="plus-btn" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">+</button>
                                <p id="qnt_msg" class="text-danger" style="display: none;"></p>
                            </div>
                            <div class="add-cart-btn">
                                <button type="submit" id='AddToCart'>
                                    add to cart
                                </button>
                            </div>
                        </form>
                    </div>

                    @if(count($promocode) > 0)
                    <div class="col-lg-6">
                        <div class="offer-title gap-2">
                            <img src="{{ asset('front_assets/images/offerImg.png')}}" alt="" width="24px">
                            <h4>Offer</h4>
                        </div>
                        @if(count($promocode) == 1)
                        <div class="offer-content-wrapper">
                            <div class="offer-content">
                                <h5>{{ $promocode['0']->code }}</h5>
                                <p>{{ $promocode['0']->description }}</p>
                            </div>
                        </div>
                        @else
                        <div id="offer-content-slider" class="offer-content-wrapper">
                            @foreach($promocode as $code)
                            <div class="offer-content">
                                <h5>{{ $code->code }}</h5>
                                <p>{{ $code->description }}</p>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
                <div class="product-details">
                    <div class="para">
                        <p>Any unknown individuals can scan the vehicle tag and notify the vehicle owner about various situations or occasions such as:</p>
                    </div>
                    <div class="benefits">
                        <ul>
                            <li class="gap-2">
                                <div>
                                    <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                                </div>
                                <p>Vehicle parked in the wrong place or prohibited area.</p>
                            </li>
                            <li class="gap-2">
                                <div>
                                    <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                                </div>
                                <p>Vehicle blocking the road or another vehicle.</p>
                            </li>
                            <li class="gap-2">
                                <div>
                                    <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                                </div>
                                <p>Vehicle left unlocked or with keys left on it. </p>
                            </li>
                        </ul>
                        <ul>
                            <li class="gap-2">
                                <div>
                                    <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                                </div>
                                <p>Threatening situations like fire in the parked vehicle area.</p>
                            </li>
                            <li class="gap-2">
                                <div>
                                    <img src="{{ asset('front_assets/images/check.png')}}" alt="">
                                </div>
                                <p>In the event of an accident, inform the victim's family members.</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="step-to-add-barcode">
    <div class="container">
        <div class="row">
            <div class="title">
                <h4>Steps to Add Barcode</h4>
            </div>
            <div class="col-lg-6">
                <div class="step-point gap-2">
                    <div>
                        <h3>1</h3>
                    </div>
                    <p>Purchase the Barcode from the Website or Salesperson</p>
                </div>
                <div class="step-point gap-2">
                    <div>
                        <h3>2</h3>
                    </div>
                    <p>A Specific Number is Mentioned on the Barcode</p>
                </div>
                <div class="step-point gap-2">
                    <div>
                        <h3>3</h3>
                    </div>
                    <p>Click on the Link Vehicle Option</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="step-point gap-2">
                    <div>
                        <h3>4</h3>
                    </div>
                    <p>Enter the Specific Barcode Number in the Barcode Field</p>
                </div>
                <div class="step-point gap-2">
                    <div>
                        <h3>5</h3>
                    </div>
                    <p>Fill in the Mandatory details and submit the form.</p>
                </div>
            </div>
            <div class="note gap-2">
                <b>Note</b>
                <p>One Barcode is assigned to only One Vehicle, it can't be used for another vehicle.</p>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="modal-description"></p>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    window.addEventListener('load', function() {
        loadJS("{{ asset('front_assets/js/aos.js') }}");
        loadJS("{{ asset('front_assets/js/jquery.validate.min.js') }}");
        loadJS("{{ asset('front_assets/js/client-jquery-2.2.0.min.js') }}");
        loadJS("{{ asset('front_assets/js/client-slick.js') }}");
        loadJS("{{ asset('front_assets/custom_js/product.js') }}");
    });
</script>
@endsection
