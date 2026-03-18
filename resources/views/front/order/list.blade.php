@extends('front.layout.master')

@section('content')

<section id="order-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @include('front.layout.my_account_navbar')
            </div>
            <div class="col-lg-12">
                <div class="order-details-wrapper text-center ">
                    <h2>Order Details</h2>
                    <div class="order-details-data table-responsive">
                        <table id="order_table" class="table table-striped table-hover dataTable no-footer">
                            <thead>
                                <tr class="bg-table-custom text-white">
                                    <th width='1%'>No</th>
                                    <th>Order Id</th>
                                    <th>Options</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                @if(count($order_list) > 0)
                                @foreach ($order_list as $key =>$order)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $order->order_id }}</td>
                                    <td>
                                        @if(!empty($order->orderdetails))
                                            @foreach ($order->orderdetails as $k=>$opt)
                                                {{ $opt['wheeler_type']  .' : '. $opt['quantity'] }} <br>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>{{ $order->created_at }}</td>
                                    <td><span class="badge bg-success">{{ ucfirst($order->status) }}</span></td>
                                    <td>
                                        @if ($order->status == 'COMPLETED')
                                            <a class="action_icon view" href="{{ url('order-detail', Crypt::encrypt($order->id) ) }}" data-id="6">
                                                <span class="material-symbols-outlined">
                                                visibility
                                                </span>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach

                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection()

@section('scripts')
<script>
    window.addEventListener('load', function() {
        loadCSS("{{ asset('front_assets/css/jquery.dataTables.min.css') }}");
        loadJS("https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js");
        loadJS("{{ asset('front_assets/custom_js/order.js') }}");
    });
</script>
@endsection
