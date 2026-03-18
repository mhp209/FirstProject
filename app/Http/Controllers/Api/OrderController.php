<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Schema;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Barryvdh\DomPDF\Facade\PDF;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Mail\OrderConfirmation;
use App\Models\barcode;
use App\Models\User;
use App\Models\order;
use App\Models\OrderHistory;
use App\Models\Address;
use App\Models\OrderDetails;
use Ixudra\Curl\Facades\Curl;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use PhonePe\payments\v1\PhonePePaymentClient;
use PhonePe\payments\v1\models\request\builders\PgPayRequestBuilder;
use PhonePe\payments\v1\models\request\builders\InstrumentBuilder;
use Illuminate\Support\Facades\Route;

class OrderController extends Controller
{
    public function index(Request $request){
        session()->flash('module', 'orderListing');
        $user_id =  $request->user_id;
        $order_list = order::with('orderdetails')->where('user_id',$user_id)->orderBy('created_at','desc')->get();

        $response = array(
            'status'         => true,
            'message'        => 'Data fetch successfully',
            "data" => [
                'address' => $order_list,
            ],
        );

        return response()->json($response);
    }
    public function order(Request $request)
    {
        $Orderdata = $request->all();
        $user_id = $Orderdata['user_id'];

        $AddressData =  Address::find($Orderdata['address_id']);
        $billing_address = $AddressData['add1'];
        $billing_address .= (!empty($AddressData['add2'])) ? ','.$AddressData['add2'] : '';

        $OrderData = [
            'user_id' => $user_id,
            'name' => $AddressData['first_name'].' '.$AddressData['last_name'],
            'price' => $Orderdata['price'],
            'discount' => ($Orderdata['discount']) ? $Orderdata['discount'] : 0,
            'promo_code' => (isset($Orderdata['promocode'])) ? $Orderdata['promocode'] : '',
            'total_amount' => $Orderdata['total_amount'],
            'quantity' => $Orderdata['quantity'],
            'billing_address' => $billing_address,
            'address_id' => $Orderdata['address_id'],
            'city' => $AddressData['city'],
            'state' => $AddressData['state'],
            'pincode' => $AddressData['pincode'],
            'mobile_number' => $AddressData['mobile_number'],
            'email' => $AddressData['email'],
            'status' => $Orderdata['status'],
            'transaction_id' => $Orderdata['transaction_id'],
            'order_id' => Generate_Order_Id(),
            'order_from' => 'apk',
            'payment_method' => $Orderdata['payment_method'],
        ];

        // $wheredata['is_online_product'] = '1';
        // $wheredata['status'] = '0';
        $wheredata['type'] = 'test';
        $barcodes_array = Barcode::where($wheredata)->orderBy('id')->limit($Orderdata['quantity'])->pluck('barcode')->toArray();
        $barcodes = implode(', ',$barcodes_array);
        $OrderData['barcodes'] = $barcodes;

        foreach($barcodes_array as $code){
            $code = str_replace(' ', '', $code);
            barcode::where('barcode', $code)->update(['customer_id' => $user_id,'status' => 1]);
        }

        $order = Order::create($OrderData);

        $products = $Orderdata['type'];

        foreach ($products as $wheeler) {
            $orderdata = new OrderDetails();
            $orderdata->order_id = $order['id'];
            $orderdata->wheeler_type = $wheeler['type'];
            $orderdata->quantity = $wheeler['quantity'];
            $orderdata->save();
        }

        $new_order = Order::with('orderdetails')->where('transaction_id', $Orderdata['transaction_id'])->first();

        // $wheredata['is_online_product'] = '1';
        // $wheredata['status'] = '0';
        $wheredata['type'] = $_ENV['BARCODE_TYPE_API'];
        $wheelerTypes = $new_order->orderdetails->pluck('wheeler_type')->unique();
        $allBarcodes = [];
        foreach ($wheelerTypes as $wheelerType) {
            $wheredata['wheeler_type'] = $wheelerType;
            $barcodes_array = Barcode::where($wheredata)
                ->where('status', '0')
                ->orderBy('id')
                ->limit($new_order->orderdetails->where('wheeler_type', $wheelerType)->first()->quantity) // Limit by quantity for this specific wheeler type
                ->pluck('barcode')
                ->toArray();
                // dd($barcodes_array);
                foreach($barcodes_array as $code){
                    $code = str_replace(' ', '', $code);
                    barcode::where('barcode', $code)->update(['customer_id' => $user_id,'status' => 1]);
                }
                $allBarcodes[$wheelerType] = implode(', ', $barcodes_array);
        }
        $orderdatas['barcodes'] = implode(', ', $allBarcodes);
        $new_order->update($orderdatas);

        $OrderHistData['customer_id'] = $user_id;
        $OrderHistData['order_id'] = $OrderData['order_id'];
        $OrderHistData['type'] = "order_create_apk";
        $OrderHistData['data'] = json_encode($OrderData);
        OrderHistory::create($OrderHistData);

        // Mail::to($order->email)->send(new OrderConfirmation($order));
        if ($order) {
            $response = array(
                'status'         => true,
                'message'        => 'Order Place Successfully',
            );
            return response()->json($response);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong! Please try again'
            ]);
        }
    }

}
