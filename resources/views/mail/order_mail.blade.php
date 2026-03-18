<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Conformation</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>

    @include('mail.header')
    <tr>
        <td align="center" style="padding: 35px 35px 20px 35px; background-color: #ffffff;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
                <tr>
                    <td align="left" style=" font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 10px;">
                        <p style="font-size: 16px; font-weight: 400; line-height: 24px; color: #202020; margin-bottom: 0;">
                            Dear {{ ucwords($order->name) }},
                        </p>
                    </td>
                </tr>
                <tr>
                    <td align="left" style=" font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 10px;">
                        <p style="font-size: 16px; font-weight: 400; line-height: 24px; color: #202020; margin-bottom: 0;">
                            Thank you for shopping with us! We're thrilled to confirm that your order has been
                            successfully placed.
                        </p>
                    </td>
                </tr>
                <tr>
                    <td align="left" style="padding-top: 20px;">
                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tr>
                                <td width="75%" align="left" bgcolor="#1a6db7" style=" font-size: 16px; font-weight: 400;  padding: 10px; color: #fff; letter-spacing: 0.5px;">
                                    Order Confirmation
                                </td>
                                <td width="25%" align="left" bgcolor="#1a6db7" style="font-size: 16px; font-weight: 400; color: #fff; padding: 10px;letter-spacing: 0.5px;">
                                    #{{ $order->order_id }}
                                </td>
                            </tr>
                            <tr>
                                <td width="75%" align="left" style=" font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">
                                    Purchased Item ({{ $order->quantity }})
                                </td>
                                <td width="25%" align="right" style=" font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">
                                    ₹ {{ price_format(RS_SAFETY_PRICE) }}
                                </td>
                            </tr>
                            <tr>
                                <td width="75%" align="left" style=" font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;">
                                    Sub Total
                                </td>
                                <td width="25%" align="right" style=" font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;">
                                    ₹ {{ price_format($order->price) }}
                                </td>
                            </tr>
                            @if(!empty($order->discount))
                            <tr>
                                <td width="75%" align="left" style=" font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;">
                                    Discount
                                </td>
                                <td width="25%" align="right" style=" font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;">
                                    - ₹ {{ price_format($order->discount) }}
                                </td>
                            </tr>
                            @endif
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="left" style="padding-top: 20px;">
                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tr>
                                <td width="75%" align="left" style=" font-size: 16px; font-weight: 400; color: #1a6db7; padding: 10px; border-top: 3px solid #9d9d9d; border-bottom: 3px solid #9d9d9d; letter-spacing: 0.5px;">
                                    TOTAL
                                </td>
                                <td width="25%" align="right" style=" font-size: 16px; font-weight: 400; color: #1a6db7; padding: 10px; border-top: 3px solid #9d9d9d; border-bottom: 3px solid #9d9d9d; letter-spacing: 0.5px;">
                                    ₹ {{ price_format($order->total_amount) }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="center" valign="top" width="100%" style="padding: 0 35px 18px 35px; background-color: #ffffff;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:660px;">
                <tr>
                    <td align="center" valign="top" style="font-size:0;">
                        <div style="display:inline-block; min-width:240px; vertical-align:top; width:100%;">
                            <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:300px;">
                                <tr>
                                    <td align="left" valign="top" style=" font-size: 16px; font-weight: 400; line-height: 24px;">
                                        <p style="color: #1a6db7; margin-bottom: 0;">Delivery Address</p>
                                        <p style="text-transform: capitalize; margin-bottom: 0;">{{$order->billing_address}}</p>

                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                    <td align="center" valign="top" style="font-size:0;">
                        <div style="display:inline-block; min-width:240px; vertical-align:top; width:100%;">
                            <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:300px;">
                                <tr>
                                    <td align="right" valign="top" style=" font-size: 16px; font-weight: 400; line-height: 24px;">
                                        <p style="color: #1a6db7; margin-bottom: 0;">Payment Method</p>
                                        <p style="text-transform: capitalize; margin-bottom: 0;">{{ $order->payment_method }}</p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="left" style=" font-size: 16px; font-weight: 400; line-height: 24px; padding: 0 35px 18px 35px;">
            <p style="font-size: 16px; font-weight: 400; line-height: 24px; color: #202020; margin-bottom: 0;">
                Your order is now being processed, and we will contact you once your order has been
                dispatched. Please note that delivery times may vary depending on your location. If you
                have any questions or concerns regarding your order, please feel free to contact us.
            </p>
        </td>
    </tr>
    <tr>
        <td align="left" style=" font-size: 16px; font-weight: 400; line-height: 24px; padding: 0 35px 35px 35px;">
            <p style="font-size: 16px; font-weight: 400; line-height: 24px; color: #202020; margin-bottom: 0;">
                Thank you for choosing us.<br>
                RoadSathi Team
            </p>
        </td>
    </tr>
    @include('mail.footer')

</body>

</html>
