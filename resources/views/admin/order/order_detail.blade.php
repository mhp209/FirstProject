@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">
    <div class="container">
        <!-- Title -->
        <div class="d-flex justify-content-between align-items-center py-3">
            <h4 class="mb-0"><a href="#" class="text-muted"></a> Order #{{ $orderdata->order_id }}</h4>
        </div>

        <!-- Main content -->
        <div class="row">
            <div class="col-lg-8">
                <!-- Details -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="mb-3 d-flex justify-content-between">
                            <div>
                                <span class="me-3">{{ $orderdata->created_at->format('d-m-Y') }}</span>
                            </div>
                            <div class="d-flex">
                                @if($orderdata->status == 'COMPLETED')
                                <a class="btn btn-link p-0 me-3 d-none d-lg-block btn-icon-text" href="{{ url('admin/order/invoice', $orderdata->id ) }}"> <button class="btn btn-primary"> <i class="fa fa-download"></i> Download Invoice</button></a>
                                @endif
                                <div class="dropdown">
                                    <button class="btn btn-link p-0 text-muted" type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-pencil"></i> Edit</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-printer"></i> Print</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <table class="table table-borderless">
                            <tbody>

                                    @foreach ($orderdata->orderdetails as $product)
                                    <tr>
                                        <td>
                                            <div class="d-flex mb-2">
                                                <div class="flex-shrink-0">
                                                    <img src="{{ asset('front_assets/images/RS-Safety-Tag.png') }}" alt="" class="img-fluid" width="50px">
                                                </div>
                                                <div class="flex-lg-grow-1 ms-3 text-center">
                                                    <h4>Rs Safety tag - {{ $product->wheeler_type }}</h4>
                                                </div>
                                            </div>
                                        </td>
                                        <td></td>
                                        <td class="text-right">{{ $product->quantity }} * ₹{{ price_format(RS_SAFETY_PRICE) }}</td>
                                    </tr>
                                    @endforeach

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right p-0">Subtotal: ₹{{ price_format($orderdata->price) }}</td>
                                </tr>
                                @if(!empty($orderdata->discount))
                                <tr>
                                    <td colspan="3" class="text-danger text-right p-0">Discount: - ₹ {{ price_format($orderdata->discount)  }}</td>
                                </tr>
                                @endif
                                <tr class="fw-bold">
                                    <td colspan="3" class="text-right p-0">Total: ₹ {{ price_format($orderdata->total_amount)  }} </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <!-- Payment -->
                @php
                $barcodes = explode(',', $orderdata->barcodes);
                @endphp
                @if(!empty($orderdata->barcodes))
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                                <div class="col-lg-12">
                                    <h4>Barcodes</h4>
                                    <h6 class="small mb-0"><span class="text-reset">{{ $orderdata->barcodes }}</span></h6>
                                </div>
                                @if(!empty($orderdata->promo_code))
                                <div class="col-lg-12 mt-4">
                                    <h4>Promocode</h4>
                                    <h6 class="small mb-0"><span class="text-reset">{{ $orderdata->promo_code }}</span></h6>
                                </div>
                                @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <div class="col-lg-4">
                <!-- Customer Notes -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h4>Payment Method</h4>
                        <p>{{ $orderdata->payment_method }} - {{ $orderdata->transaction_id }}</p>
                    </div>
                    <div class="card-body">
                        <h4>Payment Status</h4>
                        <p><span class="badge bg-success">{{ $orderdata->status }}</span></p>
                    </div>
                </div>
                <div class="card mb-4">
                    <!-- Shipping information -->
                    <div class="card-body">
                        <h4>Billing Address</h4>
                        <address>
                            <strong> {{ $orderdata->name }}</strong>
                            <p>{{ ucwords($orderdata->billing_address) }}, {{ ucwords($orderdata->city) }}, {{ ucwords($orderdata->state) }}, {{ $orderdata->pincode }}</p>
                            <p>+91 {{ $orderdata->mobile_number }}</p>
                        </address>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
