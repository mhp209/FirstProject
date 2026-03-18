@extends('front.layout.master')

@section('content')

@php
$cart = session()->get('road_sathi_cart');
$quantity = 0;
$price = 0;
$wheeler = '';
unset($cart['quantity']);
$quantity = (isset($cart['products'])) ? array_sum($cart['products']) : '';
$price = (int)$quantity * (int)RS_SAFETY_PRICE;
$code = $total_amount = $discount = '';

if(isset($cart['code']) && !empty($cart['code'])){
    $discount = GetDiscount($cart['code'],$quantity,$price);
    if($discount){
        $total_amount = $price - $discount;
        $code = $cart['code'];
    }else{
        $discount = '';
        $total_amount = $price;
        $code = '';
    }
}

@endphp

@if($quantity > 0)

<section id="about-us-banner">
    <div class="container ">
        <div class="section-title text-center ">
            <h1>Cart</h1>
        </div>
</section>

<section id="cart-section">
    <div class="container">
        <div class="row gy-3 ">
            <div class="col-lg-8">
                <div class="cart-details-wrapper">
                    <a href="#">Shopping Cart</a>
                    @if (!empty($cart))
                    @foreach ($cart['products'] as $key => $item)
                    <div class="item-wrapper gap-3 @if(isset($item) && $item == 0) d-none @endif">
                        <div class="col-lg-3 images">
                            <img src="{{ asset('front_assets/images/RS-Safety-Tag.png') }}" alt="" class="img-fluid" width="40%">
                        </div>
                        <div class="col-lg-3">
                            <h5>RS Safety Tag</h5>
                            <h6 id="wheeler">{{ $key }}</h6>
                        </div>
                        <div class="col-lg-6 quantity-wrapper">
                            <button class="btn-one minus-btn" id="minus-btn"
                                onclick="this.parentNode.querySelector('input[type=number]').stepDown()">-</button>
                            <input type="number" min="1" name="quantity" class="text-center quantity" id="quantity"
                                value="{{ $item }}" placeholder="">
                            <button class="btn-two plus-btn" id="plus-btn"
                                onclick="this.parentNode.querySelector('input[type=number]').stepUp()">+</button>

                            <button type="button" class="delete-btn cart_remove" data-mdb-toggle="tooltip"
                                title="Remove item">
                                <img src="{{ asset('front_assets/images/delete.png') }}" alt="">
                            </button>
                            <p id="qnt_msg" class="text-danger" style="display: none;"></p>
                        </div>
                    </div>
                    @endforeach
                    @endif

                </div>
                <div class="text-end">
                <a href="{{ route('product') }}" type="submit" class="continu-btn">
                    continue shopping
                </a>
                </div>
            </div>

            <div class="col-lg-4">
                <div>
                    <form method='post' action="{{ route('gotocheckout') }}">
                        <div class="summery">
                            <h5>Order Details</h5>
                            <hr>
                            <div class="order-details-price">
                                @csrf
                                <input type="hidden" name="final_price" id='final_price' value="{{ $price }}" />
                                <input type="hidden" name="final_quantity" id='final_quantity'
                                    value="{{ $quantity }}" />
                                <input type="hidden" name="promocode" id='promocode' value="{{ $code }}" />
                                <input type="hidden" name="discount" id='final_discount' value="{{ $discount }}" />
                                <input type="hidden" name="available_barcode" id='available_barcode'
                                    value="{{ AvailableBarcode() }}" />
                                <ul>
                                    <li class="d-flex ">products Price<span> ₹ {{ RS_SAFETY_PRICE }}</span></li>
                                    <li class="d-flex">
                                        <div class="total-amount">
                                            Sub Amount
                                        </div>
                                        <span class="price-total">
                                            <storang>₹</storang>
                                            <span>
                                                <storang><span id="checkout_price"> {{ $price }}</span></storang>
                                            </span>
                                        </span>
                                    </li>
                                    <div class="d-flex discountDiv justify-content-between discountClr">
                                        <div class="total-amount">
                                            Discount
                                        </div>
                                        <span class="price-total">
                                            <storang>- ₹</storang>
                                            <span>
                                                <span id="discount">  {{ $discount }} </span>
                                            </span>
                                        </span>
                                    </div>
                                    <button type="button" class="promo-code-delete discountDiv">
                                        <div id="code">{{ $code }}</div>
                                        <span class="material-symbols-outlined remove-code">
                                            delete
                                        </span>
                                    </button>
                                    <hr>
                                    <li class="d-flex">
                                        <div class="total-amount">
                                            <storang>Total Amount </storang>
                                        </div>
                                        <span class="price-total">
                                            <storang>₹</storang>
                                            <span>
                                                <storang><span id="final_amount"> {{ $total_amount }}</span></storang>
                                            </span>
                                        </span>
                                    </li>
                                </ul>
                            </div>

                        </div>
                        <button type="button" class="btn-promo-code">
                            Apply Promo Code
                            <img src="{{ asset('front_assets/images/discount.png') }}" alt="" width="24" height="24">
                        </button>
                        <button type="submit" class="chechout-btn">
                            Go to checkout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="promocodeModal" aria-hidden="true" aria-labelledby="promocodeModalLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel">promo code</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>

@else

<section id="add-cart-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="cart-wrapper text-center ">
                    <div class="images">
                        <img src="{{ asset('front_assets/images/cart.png') }}" alt="" class="img-fluid">
                    </div>
                    <a href="{{ route('product') }}">
                        <button type="submit"> Continue to Purchase </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

@endsection


@section('scripts')
<script>
    var RS_SAFETY_PRICE = '<?=RS_SAFETY_PRICE?>';
    var DISCOUNT = '<?=$discount?>';
    var DISCOUNT_CODE = '<?=$code?>';
    window.addEventListener('load', function () {
        loadJS("{{ asset('front_assets/custom_js/cart.js') }}");
    });
</script>
@endsection
