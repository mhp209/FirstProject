@extends('front.layout.master')


@section('content')
<section id="about-us-banner">
    <div class="container ">
        <div class="section-title text-center ">
            <h1>order Detail</h1>
        </div>
</section>


<section id="invoice-wrapper-section">
    <div class="container mb-4">
        <div class="row">
            <div class="back-btn">
                <a href="{{ route('order.listing') }}" class="gap-2">
                    <span class="material-symbols-outlined">
                        arrow_back
                    </span>
                    back
                </a>
            </div>
            <div class="col-lg-8">
                <div class="invoice-info-wrapper">
                    <div class="invoice-number d-flex gap-2 ">
                        <h5>Order: #{{ $orderdata->order_id }}</h5>
                        <h5></h5>
                        <div class="invoice-btn">
                            <!-- <a href="{{ url('admin/order/invoice', $orderdata->id ) }}">Invoice Download</a> -->
                            @if($orderdata->status == 'COMPLETED')
                            <a href="{{ route('order.invoice', $orderdata->id) }}">Invoice Download</a>
                            @endif
                        </div>
                    </div>
                    <div class="product-info">
                        <h5>Product</h5>
                        <h5>product name</h5>
                        <h5>Price</h5>
                    </div>
                    @if ($orderdata->order_from == 'web'|| $orderdata->order_from == 'apk')
                        @foreach ($orderdata->orderdetails as $product)
                        <div class="product-img">
                            <img src="{{ asset('front_assets/images/RS-Safety-Tag.png') }}" alt="" class="img-fluid ">
                            <h4>Rs Safety tag - {{ $product->wheeler_type }}</h4>
                            <h5> {{ $product->quantity }} * ₹ {{ price_format(RS_SAFETY_PRICE) }} </h5>
                        </div>
                        @endforeach
                    @else
                        <div class="product-img">
                            <img src="{{ asset('front_assets/images/RS-Safety-Tag.png') }}" alt="" class="img-fluid ">
                            <h4>Rs Safety tag </h4>
                            <h5> {{ $orderdata->quantity }} * ₹ {{ price_format(RS_SAFETY_PRICE) }} </h5>
                        </div>
                    @endif

                    <div class="sub-total d-flex justify-content-between ">
                        <h4></h4>
                        <h5>subtotal : ₹ {{ price_format($orderdata->price) }}</h5>
                    </div>
                    @if($orderdata->discount != 0)
                    <div class="shipping-total d-flex justify-content-between ">
                        <h4></h4>
                        <h5>Discount : - ₹ {{ price_format($orderdata->discount) }}</h5>
                    </div>
                    @endif
                    <div class="total d-flex justify-content-between ">
                        <h4></h4>
                        <h5>Total : ₹ {{ price_format($orderdata->total_amount) }}</h5>
                    </div>
                </div>

            </div>
            <div class="col-lg-4">
                <div class="payment-method-wrapper">
                    <h3>payment method</h3>
                    <div class="payment-method">
                        <p>{{ $orderdata->payment_method }}</p>
                    </div>
                    <h3>Payment Status </h3>
                    <div class="total-amount">
                        <h3><span class="badge bg-success">{{ $orderdata->status }}</span></h3>
                    </div>
                </div>
                <div class="billing-info-method-wrapper">
                    <h3>Billing Address</h3>
                    <strong>
                        {{ $orderdata->name }}
                    </strong>
                    <h5>{{ $orderdata->billing_address }}, {{ ucwords($orderdata->city) }}, {{ ucwords($orderdata->state) }}, {{ $orderdata->pincode }}</h5>
                    <div class="mobile-num">
                        <p>+91 {{ $orderdata->mobile_number }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- <section id="billing-info-wrapper-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="billing-info-wrapper">
                    <h3>Billing Address</h3>
                    <strong>
                        {{ $orderdata->name }}
                    </strong>
                    <h5>{{ $orderdata->billing_address }}</h5>
                    <div class="mobile-num">
                        <p>+91 {{ $orderdata->mobile_number }}</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section> -->

@endsection
