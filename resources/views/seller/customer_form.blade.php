@extends('admin.layouts.app')

@section('content')

@php
$selectedBarcodes = session()->get('selected_barcodes');
$quantity = count(explode (',',$selectedBarcodes));

$price = $quantity * RS_SAFETY_PRICE;
$discount = 0;
$total_amount = $price - $discount;
/* $DiscountData = GetDiscount();
$discount_qnt = $DiscountData->quantity;
$discount_amt = $DiscountData->discount;

if($quantity >= $discount_qnt){
$discount = $price * ($discount_amt / 100);
$total_amount = $price - $discount;
}else{
$discount = 0;
$total_amount = $price - $discount;
} */
@endphp

<div class="content container-fluid">

    <div class="card-header border-bottom text-bg-primary">
        <h5 class="header-title">
            Set Customer Details
        </h5>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card p-3">
                <div class="card p-3 mb-3">
                    <form method="post" action="{{ url('admin/search/customer') }}" data-parsley-validate id="roles_validate">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="customer_phone_no" class="form-label">Customer Phone Number <span class="text text-danger">*</span></label>
                                    <input type="text" name="customer_phone_no" class="form-control @error('customer_phone_no') is-invalid @enderror" id="customer_phone_no" placeholder="Enter Customer Phone Number" value="{{ $customerData->mobile_number }}">
                                    @error('customer_phone_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <a href="{{ url('admin/set-cust_del') }}" class="btn btn-danger mt-2">Cancel</a>
                                    <button type="submit" class="btn btn-primary mr-1 mt-2">
                                        <i class="ri-user-add-fill me-1"></i> Search
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    @if(!empty($customerData->first_name))
                    <div class="card p-3">

                        <div class="container mt-5">

                            <h1 class="text-center">Customer Details</h1>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Customer Name: </strong> {{ $customerData->first_name .' '. $customerData->last_name }} </p>
                                    <p><strong>Mobile Number : </strong> {{ $customerData->mobile_number }}</p>
                                </div>
                            </div>

                            <h1 class="text-center">Barcode Details</h1>
                            <div class="">
                                <form method="post" action="{{ url('admin/user/register') }}" id="payment_form">
                                    @csrf
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="hidden" name='user_id' value="{{ $customerData->id }}">
                                                <input type="hidden" name='barcodes' value="{{ $selectedBarcodes }}">
                                                <input type="hidden" name='quantity' id="quantity" value="{{ $quantity }}">
                                                <input type="hidden" name='price' id="price" value="{{ $price }}">

                                                <input type="hidden" name='discount' id="discount" value="{{ $discount }}">
                                                <input type="hidden" name='total_amount' id="total_amount" value="{{ $total_amount }}">
                                                <p><strong>Barcodes: </strong> {{ $selectedBarcodes }} </p>
                                                <p><strong>Quantity: </strong> {{ $quantity }} </p>
                                                <!-- <p><strong>Price : </strong> {{ price_format($price) }}</p> -->
                                                <!-- <div class="discount" id="discountSection" style="display: none;">
                                                    <p><strong>Discount : </strong><span id="discountcode">{{ $discount }}</span></p>
                                                </div> -->
                                                <!-- <p><strong>Total Amount : </strong><span id="totalAmount"> {{ price_format($total_amount) }}</span></p> -->

                                            </div>
                                        </div>
                                        <div class="row">
                                            @if(Auth::guard('admin')->user()->role == 'SELL_EMPLOYEE')
                                            <div class="col-md-4 mb-3">
                                                <div class="form-group">
                                                    <label for="price" class="form-label">Price <span class="text text-danger">*</span></label>
                                                    <input type="text" name="price" class="form-control @error('price') is-invalid @enderror" id="price" value="{{ price_format($price) }}" placeholder="Price" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                                    @error('price')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <div class="form-group">
                                                    <label for="payment_method" class="form-label">Payment Method <span class="text text-danger">*</span></label>
                                                    <select name="payment_method" id="payment_method" class="form-control @error('payment_method') is-invalid @enderror">
                                                        <option value="">Select payment method</option>
                                                        @foreach(paymentMethods() as $method)
                                                        <option value="{{ $method }}"> {{ $method}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('payment_method')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-4 mb-3" id="transaction_id_container">
                                                <div class="form-group">
                                                    <label for="transaction_id" class="form-label">Transaction Id <span class="text text-danger">*</span></label>
                                                    <input type="text" name="transaction_id" class="form-control @error('transaction_id') is-invalid @enderror" id="transaction_id" value="" placeholder="Enter Transaction Id">
                                                    @error('transaction_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-12 mb-3">
                                                <button type="button" id="paymentButton" class="btn btn-primary"> Create Order </button>
                                            </div>
                                            @endif

                                            <!-- <div class="col-md-4 mb-3">
                                                <div class="form-group">
                                                    <label for="code" class="form-label">Promocode</label>
                                                    <select name="promo_code" id="promocode" class="form-control">
                                                        <option value="">Select promocode</option>
                                                        @foreach($promocode as $code)
                                                        <option value="{{ $code->code }}"> {{ $code->code }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div> -->
                                            @if(Auth::guard('admin')->user()->role == 'FRANCHISE_PARTNER')
                                            <div class="col-md-12 mb-3">
                                                <button type="button" id="paymentButton" class="btn btn-primary"> Assign Barocode </button>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                    @endif

                    @if(isset($error))
                    <div class="card p-3">
                        <h4>{{ $error }}</h4>
                    </div>
                    @endif

                    <p class="text-center">OR</p>
                    <hr class="my-custom-line" style="color: #333; margin-top: 20px;">

                    <h2 class="text-center mb-1">Add New Customer</h2>
                    <form method="post" action="{{ url('admin/user/register') }}" id="form_register">
                        @csrf
                        <input type="hidden" name='barcodes' value="{{ $selectedBarcodes }}">
                        <input type="hidden" name='quantity' id="quantity" value="{{ $quantity }}">
                        <input type="hidden" name='price' id="price" value="{{ $price }}">

                        <input type="hidden" name='discount' id="discount" value="{{ $discount }}">
                        <input type="hidden" name='total_amount' id="total_amount" value="{{ $total_amount }}">

                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Barcodes: </strong> {{ $selectedBarcodes }} </p>
                                <p><strong>Quantity: </strong> {{ $quantity }} </p>
                                <!-- <p><strong>Price : </strong> {{ price_format($price) }}</p> -->
                                <!-- <div class="discount" id="discountSection" style="display: none;">
                                    <p><strong>Discount : </strong><span id="discountcode">{{ price_format($discount) }}</span></p>
                                </div>
                                <p><strong>Total Amount : </strong><span id="totalAmount"> {{ price_format($total_amount) }}</span></p> -->
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="first_name" class="form-label">First Name <span class="text text-danger">*</span></label>
                                    <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" id="first_name" value="{{ old('first_name') }}" placeholder="Enter Your First Name">
                                    @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="last_name" class="form-label">Last Name <span class="text text-danger">*</span></label>
                                    <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" id="last_name" value="{{ old('last_name') }}" placeholder="Please Enter Your Last Name">
                                    @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="email" class="form-label">Email Address <span class="text text-danger">*</span></label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Enter Your Email" autocomplete="email">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="mobile_number" class="form-label">Mobile Number</label>
                                    <input type="number" name="mobile_number" class="form-control @error('mobile_number') is-invalid @enderror" id="mobile_number" value="{{ old('mobile_number') }}" placeholder="Enter Your Mobile Number (eg:1234567890)">
                                    @error('mobile_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- <div class="col-md-4 mb-3">
                                <div class="form-group" id="password-toggle">
                                    <label for="password" class="form-label">Password <span class="text text-danger">*</span> </label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror password" name="password" placeholder="Enter Your Password" autocomplete="new-password" /> -->
                            <!-- <i class="fas fa-eye-slash" id="togglePassword"></i> -->
                            <!-- @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div> -->

                            @if(Auth::guard('admin')->user()->role == 'SELL_EMPLOYEE')
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="price" class="form-label">Price <span class="text text-danger">*</span></label>
                                    <input type="text" name="price" class="form-control @error('price') is-invalid @enderror" id="price" value="{{ price_format($price) }}" placeholder="Price" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                    @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="payment_method" class="form-label">Payment Method <span class="text text-danger">*</span></label>
                                    <select name="payment_method" id="payment_method" class="form-control @error('payment_method') is-invalid @enderror">
                                        <option value="">Select payment method</option>
                                        @foreach(paymentMethods() as $method)
                                        <option value="{{ $method }}"> {{ $method}}</option>
                                        @endforeach
                                    </select>
                                    @error('payment_method')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4 mb-3" id="transaction_id_container">
                                <div class="form-group">
                                    <label for="transaction_id" class="form-label">Transaction Id <span class="text text-danger">*</span></label>
                                    <input type="text" name="transaction_id" class="form-control @error('transaction_id') is-invalid @enderror" id="transaction_id" value="{{ old('transaction_id') }}" placeholder="Enter Transaction Id">
                                    @error('transaction_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            @endif

                            <!-- <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="code" class="form-label">Promocode</label>
                                    <select name="promo_code" id="promocode" class="form-control">
                                        <option value="">Select promocode</option>
                                        @foreach($promocode as $code)
                                        <option value="{{ $code->code }}"> {{ $code->code }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> -->

                            <!-- <div class="col-md-4 mb-3">
                                <div class="form-group" id="password-toggle">
                                    <label for="password" class="form-label"> Confirm Password  <span class="text text-danger">*</span> </label>
                                    <input id="password-confirm" type="password" class="form-control @error('password') is-invalid @enderror password" name="password-confirm" placeholder="Enter Your  Confirm Password" autocomplete="new-password" />
                                </div>
                            </div> -->

                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <a href="{{ url('admin/barcode') }}" class="btn btn-danger mt-2">Cancel</a>
                                    <button class="btn btn-primary mr-1 mt-2">
                                        <i class="ri-user-add-fill me-1"></i> Submit
                                    </button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>


</div>
@endsection

@section('script')
<script rel="preload" src="{{ asset('admin_assets/js/custom/payment.js') }}" as="script"></script>
@endsection
