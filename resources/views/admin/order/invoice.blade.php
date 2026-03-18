<?php
$admin_email = 'roadsathi@gmail.com';
$admin_mobile = '+91 987 987 5066';
?>

<?php
$logo = Generate_image("public/front_assets/images/raod-sathi-logo.jpg");
$bill_address = $county = '';
if (isset($order->address[0])) {
    $address =  $order->address[0];
    $bill_address = $address['add1'] . ',' . $address['add2'] . ',';
    $county = $address['county'];
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <link rel="stylesheet" href="{{ asset('admin_assets/css/pdf.css') }}" type="text/css">
</head>

<body>
    <table class="w-full">
        <tr>
            <td class="w-half">
                <img src="{{ $logo }}" alt="laravel daily" width="150" />
            </td>
            <td class="w-half">
                <h3>Invoice No : #{{ $order->order_id }}</h3>
            </td>
        </tr>
    </table>

    <div class="margin-top">
        <table class="w-full">
            <tr>
                <td class="w-half">
                    <div>
                        <h4>Billing Address:</h4>
                    </div>
                    <div>{{ $order->name }}</div>
                    <div>{{ $order->bill_address }}</div>
                    <div>{{ $order->city.','.$order->pincode.','.$order->state.','.$county }}</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="margin-top">
        <table class="products">
            <tr>
                <th>Product Name</th>
                @if ($order->order_from == 'web'|| $order->order_from == 'apk')
                <th>Product Type</th>
                @endif
                <th>Qty</th>
                <th>Price</th>
            </tr>
            @if ($order->order_from == 'web'|| $order->order_from == 'apk')
            @foreach ($order->orderdetails as $product)
            <tr class="items">
                <td style='text-align:center'>
                    Rs Safety tag
                </td>
                <td style='text-align:center'>
                    {{ $product->wheeler_type }}
                </td>
                <td style='text-align:center'>
                    {{ $product->quantity }}
                </td>
                <td style='text-align:center'>
                    Rs. {{ price_format(RS_SAFETY_PRICE) }}
                </td>
            </tr>
            @endforeach
            @else
            <tr class="items">
                <td style='text-align:center'>
                    Rs Safety tag
                </td>
                <td style='text-align:center'>
                    {{ $order->quantity }}
                </td>
                <td style='text-align:center'>
                    Rs. {{ price_format(RS_SAFETY_PRICE) }}
                </td>
            </tr>
            @endif
        </table>
    </div>


    <table class="w-full">
        <tr>
            <td class="w-half">
                <h5>Barcodes</h5>
                <p style="font-size: 0.875rem"> {{ $order->barcodes }} </p>
            </td>
            <td class="w-half">
                <div class="total">
                    Sub Total: Rs. {{ price_format($order->price) }}
                </div>
                @if(!empty($order->discount))
                <div class="total">
                    Discount: - Rs. {{ price_format($order->discount) }}
                </div>
                @endif
                <div class="total">
                    Total: Rs. {{ price_format($order->total_amount) }}
                </div>
            </td>
        </tr>
    </table>



    <div class="footer margin-top">
        <div>Thank you</div>
        <div>Road Sathi</div>
        <div>{{$admin_mobile}}</div>
        <div style="text-align:center"> If you have any question about this invoice, please contact <br /> {{$admin_email}}<br /> <b>Thank You For Your Business!</b> </div>

    </div>
</body>

</html>
