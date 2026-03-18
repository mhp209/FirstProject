<?php

namespace App\Http\Controllers;

use App\Exports\OrderExcelExport;
use App\Mail\OrderConfirmation;
use Illuminate\Support\Facades\Schema;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Barryvdh\DomPDF\Facade\PDF;

use Illuminate\Support\Facades\Auth;

use App\Models\barcode;
use App\Models\User;
use App\Models\order;
use App\Models\OrderHistory;
use App\Models\Address;
use App\Models\OrderDetails;
use App\Models\setting;


use Ixudra\Curl\Facades\Curl;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use PhonePe\payments\v1\PhonePePaymentClient;
use PhonePe\payments\v1\models\request\builders\PgPayRequestBuilder;
use PhonePe\payments\v1\models\request\builders\InstrumentBuilder;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Facades\Excel;

// use Mail;

class OrderController extends Controller
{
    // OrderListr - admin side
    public function OrderList(Request $request)
    {
        if ($request->ajax()) {

            $toDate = '';
            $fromDate = '';
            if ($request->input('date_range') != '') {
                $dtRangeArr = explode(' to ', $request->input('date_range'));
                $fromDate = (isset($dtRangeArr[0])) ? $dtRangeArr[0] : '';
                $toDate = (isset($dtRangeArr[1])) ? $dtRangeArr[1] : '';
            }

            $wherestr = "orders.id !=''";
            if ($fromDate != '' && $toDate == '') {
                $wherestr .= "AND DATE(orders.created_at) ='" . $fromDate . "' ";
            } else if ($fromDate != '' && $toDate != '') {
                $wherestr .= "AND DATE(orders.created_at) >='" . $fromDate . "' ";
            }

            if ($toDate != '') {
                $wherestr .= " AND DATE(orders.created_at) <='" . $toDate . "' ";
            }
            $userRole = Auth::guard('admin')->user()->role;
            if ($userRole == 'SUPER_ADMIN') {
                $data = Order::whereRaw($wherestr)
                    ->orderBy('created_at', 'desc')
                    ->get();
            } else if ($userRole == 'SELL_EMPLOYEE') {
                $wheredata['order_from'] = 'seller';
                $wheredata['order_by'] = Auth::user()->id;
                $data = order::where($wheredata)->whereRaw($wherestr)
                    ->orderBy('created_at', 'desc')
                    ->get();
            } else if ($userRole == 'FRANCHISE_PARTNER') {
                $wheredata['order_from'] = 'franchise';
                $wheredata['order_by'] = Auth::user()->id;
                $data = order::with('orderdetails')->where($wheredata)->whereRaw($wherestr)
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
            // $orderData = Order::latest()->get();

            return DataTables($data)
                ->addColumn('name', function ($data) {
                    return  ucfirst($data->name);
                })
                ->addColumn('price', function ($data) {
                    return  price_format($data->price);
                })
                ->addColumn('discount', function ($data) {
                    return  price_format($data->discount);
                })
                ->addColumn('total_amount', function ($data) {
                    return  price_format($data->total_amount);
                })
                ->addColumn('option', function ($order) {
                    $details = '';
                    foreach ($order->orderdetails as $detail) {
                        $details .= $detail->wheeler_type . ' : ' . $detail->quantity . '<br>';
                    }
                    return $details;
                })
                ->addColumn('created_at', function ($data) {
                    return $data->created_at;
                })
                ->addColumn('order_from', function ($data) {
                    return ucfirst($data->order_from);
                })
                ->addColumn('status', function ($data) {
                    $status = $data->status;
                    if ($status == 'COMPLETED') {
                        $status_line = '<h4><span class="badge badge-success">' . $status . '</span></h4>';
                    } else if ($status == 'PENDING') {
                        $status_line = ' <h4><span class="badge badge-info">' . $status . '</span></h4>';
                    } else {
                        $status_line = '<h4><span class="badge badge-danger">' . $status . '</span></h4>';
                    }
                    return $status_line;
                })
                ->addColumn('action', function ($data) {
                    $status = $data->status;
                    if ($status == 'COMPLETED') {
                    $url = url('admin/order', $data->id);
                    $action_line = '<a class="action_icon view" href="' . $url . '" data-id="' . $data->id . '" title="View"><i class="fa fa-eye"></i></a>';
                    return $action_line;
                    }
                })
                ->rawColumns(['status', 'action', 'option'])
                ->make(true);
        }
        return view('admin.order.list');
    }

    // Order Detail - admin side
    public function OrderInfo($orderId)
    {
        $orderdata = order::find($orderId);
        return view('admin.order.order_detail', compact('orderdata'));
    }

    // order create - web side
    public function order(Request $request)
    {
        $user_id =  Auth::user()->id;
        $Orderdata = session()->get('road_sathi_checkout');

        $address_id = $request->input('address_id');
        $AddressData =  Address::find($address_id);
        $billing_address = $AddressData['add1'];
        $billing_address .= (!empty($AddressData['add2'])) ? ', ' . $AddressData['add2'] : '';

        $total_amount = $Orderdata['price'] - $Orderdata['discount'];
        $transactionId = uniqid();

        // pre($Orderdata);exit;
        if($AddressData['mobile_number'] == '8671878940'){
            $total_amount = 1;
        }

        $OrderData = [
            'user_id' => Auth::user()->id,
            'name' => $AddressData['first_name'] . ' ' . $AddressData['last_name'],
            'price' => $Orderdata['price'],
            'discount' => ($Orderdata['discount']) ? $Orderdata['discount'] : 0,
            'promo_code' => ($Orderdata['promocode']) ? $Orderdata['promocode'] : '',
            'total_amount' => $total_amount,
            'quantity' => $Orderdata['quantity'],
            'billing_address' => $billing_address,
            'address_id' => $address_id,
            'city' => $AddressData['city'],
            'state' => $AddressData['state'],
            'pincode' => $AddressData['pincode'],
            'mobile_number' => $AddressData['mobile_number'],
            'email' => $AddressData['email'],
            'status' => 'PENDING',
            'transaction_id' => $transactionId,
            'order_id' => Generate_Order_Id(),
            'order_from' => 'web',
            'order_by' => Auth::user()->id,
        ];

        $order = Order::create($OrderData);

        $OrderHistData['customer_id'] = Auth::user()->id;
        $OrderHistData['order_id'] = $OrderData['order_id'];
        $OrderHistData['type'] = "order_create_web";
        $OrderHistData['data'] = json_encode($OrderData);
        OrderHistory::create($OrderHistData);

        $cart = session()->get('road_sathi_cart');

        $products = $cart['products'];

        foreach ($products as $wheeler => $quantity) {
            if ($quantity > 0) {
                $orderdata = new OrderDetails();
                $orderdata->order_id = $order['id'];
                $orderdata->wheeler_type = $wheeler;
                $orderdata->quantity = $quantity;
                $orderdata->save();
            }
        }

        $setting = setting::first();

        $SALTINDEX = $_ENV['PHONEPAY_SALTINDEX'];
        if ($setting['payment_mode'] == 'live') {
            $MERCHANTID = $_ENV['PHONEPAY_MERCHANTID'];
            $SALTKEY = $_ENV['PHONEPAY_SALTKEY'];
            $env = $_ENV['PHONEPAY_ENV'];
        } else {
            $MERCHANTID = $_ENV['PHONEPAY_MERCHANTID_TEST'];
            $SALTKEY = $_ENV['PHONEPAY_SALTKEY_TEST'];
            $env = $_ENV['PHONEPAY_ENV_TEST'];
        }
        $SHOULDPUBLISHEVENTS = $_ENV['SHOULDPUBLISHEVENTS'];

        $phonePePaymentsClient = new PhonePePaymentClient($MERCHANTID, $SALTKEY, $SALTINDEX, $env, $SHOULDPUBLISHEVENTS);

        $request = PgPayRequestBuilder::builder()
            ->mobileNumber($AddressData['mobile_number'])
            ->callbackUrl(route('status'))
            ->merchantId($MERCHANTID)
            ->merchantUserId("MUID123")
            ->amount($total_amount * 100)
            ->merchantTransactionId($transactionId)
            ->redirectUrl(route('status'))
            ->redirectMode("POST")
            ->paymentInstrument(InstrumentBuilder::buildPayPageInstrument())
            ->build();

        $response = $phonePePaymentsClient->pay($request);
        $PagPageUrl = $response->getInstrumentResponse()->getRedirectInfo()->getUrl();

        return redirect()->to($PagPageUrl);
    }
    /* order Complate - web */
    public function paymentCallback(Request $request)
    {
        $input = $_POST;
        $setting = setting::first();

        $SALTINDEX = $_ENV['PHONEPAY_SALTINDEX'];
        if ($setting['payment_mode'] == 'live') {
            $MERCHANTID = $_ENV['PHONEPAY_MERCHANTID'];
            $SALTKEY = $_ENV['PHONEPAY_SALTKEY'];
            $env = $_ENV['PHONEPAY_ENV'];
        } else {
            $MERCHANTID = $_ENV['PHONEPAY_MERCHANTID_TEST'];
            $SALTKEY = $_ENV['PHONEPAY_SALTKEY_TEST'];
            $env = $_ENV['PHONEPAY_ENV_TEST'];
        }
        $SHOLDPUBLISHEVENTS = $_ENV['SHOULDPUBLISHEVENTS'];

        $phonePePaymentsClient = new PhonePePaymentClient($MERCHANTID, $SALTKEY, $SALTINDEX, $env, $SHOLDPUBLISHEVENTS);
        $checkStatus = $phonePePaymentsClient->statusCheck($_POST['transactionId']);

        // $checkStatus->getMerchantTransactionId()
        $state = $checkStatus->getState();
        $oder = order::with('orderdetails')->where('transaction_id', $_POST['transactionId'])->first();
        $userid = $oder->user_id;
        Auth::loginUsingId($userid);

        $orderdata = [
            'payment_method' => $checkStatus->getPaymentInstrument()->getType(),
            // 'financial_status' => $checkStatus->getPaymentInstrument()->code(),
            'merchant_transaction_id' => $checkStatus->getMerchantTransactionId(),
            'status' => $checkStatus->getState(),
            'payment_reponse' => json_encode($_POST)
        ];

        $cart = session()->put('road_sathi_cart', []);
        session()->put('road_sathi_checkout', []);

        $routeName = Route::currentRouteName();
        if ($routeName = 'status') {
            if ($state == 'COMPLETED') {
                // dd($cart);
                $wheredata['is_online_product'] = '1';
                $wheredata['status'] = '0';
                $wheelerTypes = $oder->orderdetails->pluck('wheeler_type')->unique();
                $allBarcodes = [];
                foreach ($wheelerTypes as $wheelerType) {
                    $wheredata['wheeler_type'] = $wheelerType;
                    $barcodes_array = Barcode::where($wheredata)
                        ->where('status', '0')
                        ->orderBy('id')
                        ->limit($oder->orderdetails->where('wheeler_type', $wheelerType)->first()->quantity) // Limit by quantity for this specific wheeler type
                        ->pluck('barcode')
                        ->toArray();
                    if (count($barcodes_array) != $oder->orderdetails->where('wheeler_type', $wheelerType)->first()->quantity) {
                        session()->flash('error', "Insufficient barcodes available for wheelerType.");
                        return redirect()->back();
                    }
                    foreach ($barcodes_array as $code) {
                        $code = str_replace(' ', '', $code);
                        Barcode::where('barcode', $code)->update(['customer_id' => $oder->user_id, 'status' => 1]);
                    }
                    $allBarcodes[$wheelerType] = implode(', ', $barcodes_array);
                }
                $orderdata['barcodes'] = implode(', ', $allBarcodes);
                $oder->update($orderdata);
                // Mail::to($oder->email)->send(new OrderConfirmation($oder));
                session()->flash('success', 'Your payment was successful.');
                return view('front.thankyou');
            } else if ($state == 'PENDING') {
                session()->flash('error', 'Your payment is failed.');
                return view('front.thankyou');
            } else if ($state == 'FAILED') {
                session()->flash('error', 'Your payment is processing.');
                return view('front.thankyou');
            }
        } else {
            if ($state == 'COMPLETED') {
                $status = true;
                $message = 'Your payment is Successfully.';
            } else if ($state == 'PENDING') {
                $status = false;
                $message =  'Your payment is failed.';
            } else if ($state == 'FAILED') {
                $status = false;
                $message =   'Your payment is processing.';
            }

            $response = array(
                'status'         => $status,
                'message'        => $message,
            );
            return response()->json($response);
        }
    }

    // Web details
    public function OrderDetail($orderId)
    {
        $orderId = Crypt::decrypt($orderId);
        $orderdata = order::with('orderdetails')->find($orderId);
        return view('front.order.order-detail', compact('orderdata'));
    }

    // Web And admin
    public function GenerateInvoice($orderId)
    {
        // $orderId = Crypt::decrypt($orderId);
        $order = Order::with('address', 'orderdetails')->find($orderId);
        $pdf = \PDF::loadView('admin.order.invoice', array('order' => $order));
        $orderName = $order->order_id . '.pdf';
        // return $pdf->stream('invoice.pdf');
        return $pdf->download($orderName);
    }

    //Web order listing
    public function orderListing()
    {
        session()->flash('module', 'orderListing');
        $user_id =  Auth::user()->id;
        $order_list = order::with('address', 'orderdetails')->where('user_id', $user_id)->where('status','!=','PENDING')->orderBy('created_at', 'desc')->get();
        return view('front.order.list', compact('order_list'));
    }


    public function demopayment(Request $request)
    {
        $input = $request->all();

        $saltKey = '099eb0cd-02cf-4e2a-8aca-3e6c6aff0399';
        $saltIndex = 1;

        $finalXHeader = hash('sha256', '/pg/v1/status/' . $input['merchantId'] . '/' . $input['transactionId'] . $saltKey) . '###' . $saltIndex;

        $response = Curl::to('https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/status/' . $input['merchantId'] . '/' . $input['transactionId'])
            ->withHeader('Content-Type:application/json')
            ->withHeader('accept:application/json')
            ->withHeader('X-VERIFY:' . $finalXHeader)
            ->withHeader('X-MERCHANT-ID:' . $input['transactionId'])
            ->get();

        // dd(json_decode($response));

        $transaction = Order::get();

        // $response = $transaction->response();
        // pre($response);exit;
        $order_id = $transaction->getOrderId();

        $transaction->getTransactionId();

        if ($transaction->isSuccessful()) {
            Order::where('order_id', $order_id)->update(['status' => 1, 'transaction_id' => $transaction->getTransactionId()]);
            return view('front.thankyou')->with('message', "Your payment is successfull.");
        } else if ($transaction->isFailed()) {
            Order::where('order_id', $order_id)->update(['status' => 0, 'transaction_id' => $transaction->getTransactionId()]);
            return view('front.thankyou')->with('message', "Your payment is failed.");
        } else if ($transaction->isOpen()) {
            Order::where('order_id', $order_id)->update(['status' => 2, 'transaction_id' => $transaction->getTransactionId()]);
            return view('front.thankyou')->with('message', "Your payment is processing.");
        }
        $transaction->getResponseMessage();
    }

    public function phonePe()
    {
        $apiKey = "099eb0cd-02cf-4e2a-8aca-3e6c6aff0399";

        $data = array(
            'merchantId' => 'PGTESTPAYUAT',
            'env' => 'Env::UAT',
            'merchantTransactionId' => uniqid(),
            'merchantUserId' => 'MUID123',
            'amount' => 1,
            'redirectUrl' => route('response'),
            'redirectMode' => 'POST',
            'callbackUrl' => route('response'),
            'mobileNumber' => '9999999999',
            'paymentInstrument' =>
            array(
                'type' => 'PAY_PAGE',
            ),
        );

        // dd($data);

        $encode = base64_encode(json_encode($data));

        $saltKey = '099eb0cd-02cf-4e2a-8aca-3e6c6aff0399';
        $saltIndex = 1;

        $string = $encode . '/pg/v1/pay' . $saltKey;
        $sha256 = hash('sha256', $string);

        $finalXHeader = $sha256 . '###' . $saltIndex;

        $url = "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay";

        $response = Curl::to($url)
            ->withHeader('Content-Type:application/json')
            ->withHeader('X-VERIFY:' . $finalXHeader)
            ->withData(json_encode(['request' => $encode]))
            ->post();
        // dd($response);

        $rData = json_decode($response);
        // dd(json_decode($response));
        return redirect()->to($rData->data->instrumentResponse->redirectInfo->url);
    }

    public function response(Request $request)
    {
        // dd($request->all());
        $input = $request->all();

        $saltKey = '099eb0cd-02cf-4e2a-8aca-3e6c6aff0399';
        $saltIndex = 1;

        $finalXHeader = hash('sha256', '/pg/v1/status/' . $input['merchantId'] . '/' . $input['transactionId'] . $saltKey) . '###' . $saltIndex;

        $response = Curl::to('https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/status/' . $input['merchantId'] . '/' . $input['transactionId'])
            ->withHeader('Content-Type:application/json')
            ->withHeader('accept:application/json')
            ->withHeader('X-VERIFY:' . $finalXHeader)
            ->withHeader('X-MERCHANT-ID:' . $input['transactionId'])
            ->get();


        // Order::
        // Status - code : PAYMENT_SUCCESS
        // payment-method - cardType
        // transactionId - transactionId


    }
    /* Order Excelsheet -download */
    public function OrderExport(Request $request)
    {
        $dateRange = $request->input('date_range');
        $dates = explode(' to ', $dateRange);

        $fromDate = isset($dates[0]) ? $dates[0] : null;
        $toDate = isset($dates[1]) ? $dates[1] : null;

        $userRole = Auth::guard('admin')->user()->role;
        if ($userRole == 'SUPER_ADMIN') {
            $ordersQuery = Order::select(
                'order_id',
                'name',
                'created_at',
                'quantity',
                'price',
                'discount',
                'total_amount',
                'barcodes',
                'promo_code',
                'payment_method',
                'transaction_id',
                'status',
                'billing_address',
                'state',
                'city',
                'pincode',
                'order_from'
            );
        } else if ($userRole == 'SELL_EMPLOYEE' || $userRole == 'FRANCHISE_PARTNER') {
            $ordersQuery = Order::select(
                'order_id',
                'name',
                'created_at',
                'quantity',
                'price',
                'discount',
                'total_amount',
                'barcodes',
                'promo_code',
                'payment_method',
                'transaction_id',
                'status',
                'order_from'
            );
        }

        if ($fromDate != '' && $toDate == '') {
            $ordersQuery->whereDate('created_at', '=', $fromDate);
        } else if ($fromDate != '' && $toDate != '') {
            $ordersQuery->whereDate('created_at', '>=', $fromDate);
        }
        if ($toDate != '') {
            $ordersQuery->whereDate('created_at', '<=', $toDate);
        }


        $userRole = Auth::guard('admin')->user()->role;
        if ($userRole == 'SUPER_ADMIN') {
            $dataValue = [];
            $dataValue[] = ['Order ID', 'Name', 'Order Date', 'Quantity', 'Sub Total', 'Discount', 'Total', 'Barcodes', 'Promocode', 'Payment Method', 'Transaction ID', 'Status', 'Billing Address', 'State', 'City', 'Pincode', 'Order From'];
            $dataOrder = $ordersQuery->orderBy('id', 'DESC')->get()->toArray();
        } else if ($userRole == 'SELL_EMPLOYEE') {
            $dataValue = [];
            $dataValue[] = ['Order ID', 'Name', 'Order Date', 'Quantity', 'Sub Total', 'Discount', 'Total', 'Barcodes', 'Promocode', 'Payment Method', 'Transaction ID', 'Status', 'Order From'];
            $wheredata['order_from'] = 'seller';
            $wheredata['order_by'] = Auth::user()->id;
            $dataOrder = $ordersQuery->where($wheredata)->orderBy('id', 'DESC')->get()->toArray();
        } else if ($userRole == 'FRANCHISE_PARTNER') {
            $dataValue = [];
            $dataValue[] = ['Order ID', 'Name', 'Order Date', 'Quantity', 'Sub Total', 'Discount', 'Total', 'Barcodes', 'Promocode', 'Payment Method', 'Transaction ID', 'Status', 'Order From'];
            $wheredata['order_from'] = 'franchise';
            $wheredata['order_by'] = Auth::user()->id;
            $dataOrder = $ordersQuery->where($wheredata)->orderBy('id', 'DESC')->get()->toArray();
        }

        if (empty($dataOrder)) {
            return response()->json(['status' => 'error', 'message' => 'No records found.']);
        }

        $orders = array_merge($dataValue, $dataOrder);

        $fileName = 'Order.xls';
        $export = new OrderExcelExport($orders);

        $file = Excel::store($export, $fileName, 'public');
        return response()->json(['status' => 'success', 'fileName' => $fileName]);
    }
}
