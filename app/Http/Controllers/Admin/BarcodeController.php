<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ExcelExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromArray;

use App\Models\barcode;
use App\Models\Admin;
use App\Models\BarcodeHistories;
use App\Models\User;
use App\Models\order;
use App\Models\Log;
use App\Models\OrderHistory;
use App\Models\Promocode;
use App\Models\OrderDetails;
use DataTables;
use DB;

class BarcodeController extends Controller
{
    /* generate barcode List */
    public function generateBarcode(Request $request)
    {
        if (Auth::guard('admin')->user()->role == 'SELL_EMPLOYEE') {
            $admin_id = Auth::guard('admin')->user()->id;
            $barcode_list = Barcode::orderBy('created_at', 'desc')->get();
            return view('seller.barcode_list', compact('barcode_list'));
        } else {
            if ($request->ajax()) {

                $toDate = '';
                $fromDate = '';
                if ($request->input('date_range') != '') {
                    $dtRangeArr = explode(' to ', $request->input('date_range'));
                    $fromDate = (isset($dtRangeArr[0])) ? $dtRangeArr[0] : '';
                    $toDate = (isset($dtRangeArr[1])) ? $dtRangeArr[1] : '';
                }

                $wherestr = "barcode.id !=''";
                if ($fromDate != '' && $toDate == '') {
                    $wherestr .= "AND DATE(barcode.created_at) ='" . $fromDate . "' ";
                } else if ($fromDate != '' && $toDate != '') {
                    $wherestr .= "AND DATE(barcode.created_at) >='" . $fromDate . "' ";
                }

                if ($toDate != '') {
                    $wherestr .= " AND DATE(barcode.created_at) <='" . $toDate . "' ";
                }

                $barcode_list =  Barcode::with('customer', 'vehicle', 'adminRole', 'adminRoleSeller')
                    ->whereRaw($wherestr)
                    ->orderBy('created_at', 'desc')
                    ->get();

                return DataTables($barcode_list)
                    ->addColumn('type', function ($barcode_list) {
                        return ucwords($barcode_list->type);
                    })
                    ->addColumn('wheeler_type', function ($barcode_list) {
                        return ucwords($barcode_list->wheeler_type);
                    })
                    ->addColumn('customer', function ($barcode_list) {
                        return ($barcode_list->customer) ? ($barcode_list->customer->name) : '';
                    })
                    ->addColumn('assign_to', function ($barcode_list) {
                        return ucwords($barcode_list->assign_to) ? ucwords($barcode_list->adminRoleSeller->name ?? "") : '';
                    })
                    ->addColumn('uploaded_by', function ($barcode_list) {
                        return ucwords($barcode_list->adminRole->name ?? "");
                    })
                    ->addColumn('linked', function ($barcode_list) {
                        return (!empty($barcode_list->vehicle)) ? " Linked " : "";
                    })
                    ->addColumn('created_at', function ($barcode_list) {
                        // return date('Y-m-d H:i:s',$barcode_list->created_at);
                        return $barcode_list->created_at;
                    })
                    ->addColumn('status', function ($barcode_list) {
                        $status = $barcode_list->status == '0' ? '<i class="fa fa-dot-circle-o text-danger"></i> Inactive' : '<i class="fa fa-dot-circle-o text-success"></i> Active';
                        $toggleValue = $barcode_list->status == '0' ? '1' : '0';

                        $status_line =  '<div class="dropdown action-label">';
                        $status_line .= '<a class="btn btn-white btn-sm btn-rounded dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton" href="javascript:;" aria-expanded="false" data-id="' . $barcode_list->id . '" value="' . $toggleValue . '">' . $status . '</a>';

                        $status_line .= '<div class="dropdown-menu dropdown-menu-right">';
                        $status_line .= '<a class="dropdown-item status" href="javascript:;" data-id="' . $barcode_list->id . '" value="1"><i class="fa fa-dot-circle-o text-success"></i> Active</a>';
                        $status_line .= '<a class="dropdown-item status" href="javascript:;" data-id="' . $barcode_list->id . '" value="0"><i class="fa fa-dot-circle-o text-danger"></i> Inactive</a>';
                        $status_line .= '</div></div>';
                        return $status_line;
                    })
                    ->rawColumns(['status', 'linked'])
                    ->make(true);
            }
            return view('admin.barcode.generate_barcode');
        }
    }
    /* Excel sheet download */
    public function export_barcode($code)
    {
        $data = [];
        $data[] = ['value' => 'Barcode'];
        $barcode = barcode::where('code', $code)->select('barcode as value')->get()->toArray();
        $data = array_merge($data, $barcode);
        return Excel::download(new class($data) implements FromArray
        {
            protected $data;
            public function __construct(array $data)
            {
                $this->data = $data;
            }
            public function array(): array
            {
                return $this->data;
            }
        }, 'Barcode.xls');
    }
    /* generate barcode store and franchise order */
    public function store(Request $request)
    {
        $rules =  [
            'assign_to' => 'required',
            'status' => 'required',
            'count' => 'required',
            'wheeler_type' => 'required',
        ];

        $validatedData = $request->validate($rules);

        $PostData = $request->all();

        $admin = Admin::where('id', $request->assign_to)->select('role', 'name','mobile_number','email')->first();
        // dd($admin);
        $type = ($admin->role == 'SELL_EMPLOYEE') ? 'seller' : 'franchise';

        $wheredata['type'] = $type;
        $wheredata['wheeler_type'] = $PostData['wheeler_type'];
        $wheredata['status'] = '0';
        $barcodes_array = barcode::where($wheredata)->orderBy('id')->limit($request->count)->pluck('barcode')->toArray();

        // dd($barcodes_array);
        $code = date('YmdHis');

        $data = [];
        $data[] = ['value' => 'barcode'];
        foreach ($barcodes_array as $barcode) {
            $data[] = ['value' => $barcode];
            $barcode = barcode::where('barcode', $barcode)->update([
                'assign_to' => $request->assign_to,
                'status' => $request->status,
                'code' => $code,
            ]);
        }
        $barcode = BarcodeHistories::firstOrcreate([
            'assign_to' => $request->assign_to,
            'wheeler_type' => $request->wheeler_type,
            'count' => $request->count,
            'code' => $code,
        ]);

        if ($admin->role == 'FRANCHISE_PARTNER')
        {
            $Orderdata['name'] = $admin->name;
            $Orderdata['mobile_number'] = $admin->mobile_number;
            $Orderdata['email'] = $admin->email;
            $Orderdata['barcodes'] = implode(',', $barcodes_array);
            $Orderdata['price'] = $PostData['price'];
            $Orderdata['total_amount'] = $PostData['price'];
            $Orderdata['quantity'] = $barcode->count;

            $Orderdata['financial_status'] = 'COMPLETED';
            $Orderdata['status'] = 'COMPLETED';
            $Orderdata['financial_status'] = 'COMPLETED';
            $Orderdata['status'] = 'COMPLETED';
            $Orderdata['order_id'] = Generate_Order_Id();
            $Orderdata['order_by'] = Auth::user()->id;
            $Orderdata['order_from'] = 'franchise';

            $order = order::create($Orderdata);
            // Mail::to($order->email)->send(new OrderConfirmation($order));

            $OrderHistData['admin_id'] = Auth::guard('admin')->user()->id;
            // $OrderHistData['customer_id'] = $Orderdata['user_id'];
            $OrderHistData['order_id'] = $Orderdata['order_id'];
            $OrderHistData['barcode'] = $Orderdata['barcodes'];
            $OrderHistData['type'] = "order_create_admin";
            $OrderHistData['data'] = json_encode($Orderdata);
            OrderHistory::create($OrderHistData);

            $orderdetails['order_id'] = $order['id'];
            $orderdetails['wheeler_type'] = $barcode['wheeler_type'];
            $orderdetails['quantity'] = $barcode['count'];
            OrderDetails::create($orderdetails);
        }
        $message = 'Barcodes Add Successfully';
        return redirect()->to('admin/barcode')->with('success', $message);
    }
    /* Total Barcode Count */
    public function totalBarcode(Request $request)
    {
        $wheeler_type = $request->input('wheeler_type');
        $admin = Admin::where('id', $request->assign_to)->select('role')->first();
        $type = ($admin->role == 'SELL_EMPLOYEE') ? 'seller' : 'franchise';
        if ($type == 'seller') {
            $prefix = ($wheeler_type == '2 Wheeler') ? 'S2RS' : 'S4RS';
        } elseif ($type == 'franchise') {
            $prefix = ($wheeler_type == '2 Wheeler') ? 'F2RS' : 'F4RS';
        }
        $wheredata['assign_to'] = '0';
        $totalRecords = Barcode::where('type', $type)->where($wheredata)
            ->where('barcode', 'like', $prefix . '%')
            ->count();
        $data['TotalBarcode'] = $totalRecords;
        return response()->json($data);
    }

    /* Seller and Franchise barcode */
    public function index(Request $request)
    {
        if (Auth::guard('admin')->user()->role == 'SELL_EMPLOYEE' || Auth::guard('admin')->user()->role == 'FRANCHISE_PARTNER') {

            $admin_id = Auth::guard('admin')->user()->id;

            if ($request->ajax()) {

                $toDate = '';
                $fromDate = '';
                if ($request->input('date_range') != '') {
                    $dtRangeArr = explode(' to ', $request->input('date_range'));
                    $fromDate = (isset($dtRangeArr[0])) ? $dtRangeArr[0] : '';
                    $toDate = (isset($dtRangeArr[1])) ? $dtRangeArr[1] : '';
                }

                $wherestr = "barcode.id !=''";
                if ($fromDate != '' && $toDate == '') {
                    $wherestr .= "AND DATE(barcode.created_at) ='" . $fromDate . "' ";
                } else if ($fromDate != '' && $toDate != '') {
                    $wherestr .= "AND DATE(barcode.created_at) >='" . $fromDate . "' ";
                }

                if ($toDate != '') {
                    $wherestr .= " AND DATE(barcode.created_at) <='" . $toDate . "' ";
                }

                $data =  Barcode::with('customer')
                    ->whereRaw($wherestr)
                    ->where('assign_to', $admin_id)
                    ->orderBy('created_at', 'desc')
                    ->orderBy('status', 'desc')
                    ->get();

                return DataTables($data)
                    ->addColumn('checkbox', function ($data) {
                        $checked =  (!empty($data->customer)) ? 'disabled' : '';
                        $line  = '<input id="' . $data->barcode . '" type="checkbox" ' . $checked . '>';
                        $line .= '<label for="' . $data->barcode . '"  ></label>';
                        return $line;
                    })
                    ->addColumn('customer', function ($data) {
                        return ($data->customer) ? ucwords($data->customer->name) : '';
                    })
                    ->addColumn('mobile', function ($data) {
                        return ($data->customer) ? ucwords($data->customer->mobile_number) : '';
                    })
                    ->addColumn('email', function ($data) {
                        return ($data->customer) ? ucwords($data->customer->email) : '';
                    })
                    ->addColumn('status', function ($data) {
                        $status = $data->status == '0' ? '<i class="fa fa-dot-circle-o text-danger"></i> Inactive' : '<i class="fa fa-dot-circle-o text-success"></i> Active';
                        $toggleValue = $data->status == '0' ? '1' : '0';

                        $status_line =  '<div class="dropdown action-label">';
                        $status_line .= '<a class="btn btn-white btn-sm btn-rounded dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton" href="javascript:;" aria-expanded="false" data-id="' . $data->id . '" value="' . $toggleValue . '">' . $status . '</a>';

                        $status_line .= '<div class="dropdown-menu dropdown-menu-right">';
                        $status_line .= '<a class="dropdown-item status" href="javascript:;" data-id="' . $data->id . '" value="1"><i class="fa fa-dot-circle-o text-success"></i> Active</a>';
                        $status_line .= '<a class="dropdown-item status" href="javascript:;" data-id="' . $data->id . '" value="0"><i class="fa fa-dot-circle-o text-danger"></i> Inactive</a>';
                        $status_line .= '</div></div>';
                        return $status_line;
                    })
                    ->rawColumns(['checkbox', 'status', 'mobile', 'email'])
                    ->make(true);
            }
            return view('seller.barcode_list');
        } else {
            $user_list = Admin::whereIn('role', ['SELL_EMPLOYEE', 'FRANCHISE_PARTNER'])
                ->where('status', 1)
                ->get();

            if ($request->ajax()) {

                $toDate = '';
                $fromDate = '';
                if ($request->input('date_range') != '') {
                    $dtRangeArr = explode(' to ', $request->input('date_range'));
                    $fromDate = (isset($dtRangeArr[0])) ? $dtRangeArr[0] : '';
                    $toDate = (isset($dtRangeArr[1])) ? $dtRangeArr[1] : '';
                }

                $wherestr = "barcode_histories.id !=''";
                if ($fromDate != '' && $toDate == '') {
                    $wherestr .= "AND DATE(barcode_histories.created_at) ='" . $fromDate . "' ";
                } else if ($fromDate != '' && $toDate != '') {
                    $wherestr .= "AND DATE(barcode_histories.created_at) >='" . $fromDate . "' ";
                }

                if ($toDate != '') {
                    $wherestr .= " AND DATE(barcode_histories.created_at) <='" . $toDate . "' ";
                }

                $data = BarcodeHistories::whereRaw($wherestr)
                    ->where('count','!=','0')
                    ->orderBy('created_at', 'desc')
                    ->get();

                return DataTables($data)
                    ->addColumn('assign_to', function ($data) {
                        $assignTo = $data->assign_to ?? '';
                        return ucwords(getadminNameWrole($assignTo));
                    })
                    ->addColumn('wheeler_type', function ($data) {
                        return $data->wheeler_type;
                    })
                    ->addColumn('created_at', function ($data) {
                        return $data->created_at;
                    })
                    ->addColumn('downlaod', function ($data) {
                        $url = route('admin.export_barcode', $data->code);
                        $reassignurl = route('reassign.barcode', $data->code);
                        $downlaod_line = '<a class="btn btn-xs btn-info m-r-5" href="' . $url . '" title="Download"><i class="fa fa-download"></i></a>';
                        if ($data->count !== 0) {
                            $downlaod_line .= '<a class="btn btn-xs btn-danger" href="' . $reassignurl . '" title="Reassign">Reassign</a>';
                        }
                        return $downlaod_line;
                    })
                    ->rawColumns(['downlaod'])
                    ->make(true);
            }
            return view('admin.barcode.form', compact('user_list'));
        }
    }

    /* Generate Barcode Store */
    public function export(Request $request)
    {
        $rules = [
            'number' => ['required', 'number'],
            'type' => ['required']
        ];

        $barcodeData = Generate_Barcode($request);

        if (!$barcodeData) {
            return redirect()->route('generate.barcode')->with('error', 'Invalid barcode type.');
        }

        // $barcodeData = $request->all();
        // $number = $request->number;
        // $type = $request->type;
        // $wheeler_type = $request->wheeler_type;
        // $whereType['type'] = $type;
        // $whereType['wheeler_type'] = $wheeler_type;
        // $last_record = Barcode::select('barcode')->where($whereType)->orderBy('barcode', 'desc')->first();
        // if ($last_record) {
        //     $lastBarcode = $last_record['barcode'];
        //     $numericPart = substr($lastBarcode, 4);
        //     // dd($numericPart);
        //     $lastRecordNumericPart = (int)$numericPart;
        // } else {
        //     $lastRecordNumericPart = 0;
        // }
        // if ($request->filled('type')) {
        //     $data = [];
        //     $data[] = ['value' => 'Barcode'];
        //     for ($i = 0; $i < $number; $i++) {
        //         $lastRecordNumericPart++;
        //         if ($type == 'web') {
        //             $prefix = ($wheeler_type == '2 Wheeler') ? 'W2RS' : 'W4RS';
        //         } elseif ($type == 'seller') {
        //             $prefix = ($wheeler_type == '2 Wheeler') ? 'S2RS' : 'S4RS';
        //         } elseif ($type == 'franchise') {
        //             $prefix = ($wheeler_type == '2 Wheeler') ? 'F2RS' : 'F4RS';
        //         } elseif ($type == 'test') {
        //             $prefix = ($wheeler_type == '2 Wheeler') ? 'T2RS' : 'T4RS';
        //         } else {
        //             $prefix = '';
        //         }

        //         if (!empty($prefix)) {
        //             $barcodeValue = $prefix . str_pad($lastRecordNumericPart, 10, '0', STR_PAD_LEFT);

        //             $barcodeSave = Barcode::create([
        //                 'barcode' => $barcodeValue,
        //                 'type' => $type,
        //                 'wheeler_type' => $wheeler_type,
        //                 'status' => '0',
        //                 'is_online_product' => ($type == 'web') ? 1 : 0,
        //                 'uploaded_by' => Auth::guard('admin')->user()->id
        //             ]);
        //             $data[] = ['value' => $barcodeValue];
        //         }
        //     }
        // }


        $fileName = 'Barcode_' . date('YmdHis') . '.xls';
        $export = new ExcelExport($barcodeData);

        $file = Excel::store($export, 'Barcode_' . date('YmdHis') . '.xls', 'public');

        return redirect()->route('generate.barcode')->with('download', true)->with('fileName', $fileName);
    }

    public function delete_file(Request $request)
    {
        $fileName =  $request->fileName;
        $filePath = storage_path('app/public/') . $fileName;
        if (file_exists($filePath)) {
            unlink($filePath);
            return response()->json(['status' => 'success'])->header('Content-Type', 'application/json');;
        } else {
            return response()->json(['status' => 'error', 'message' => 'File not found'], 404);
        }
    }

    public function BarcodeStatus(Request $request)
    {
        $id = $request->input('id');
        $safety_option = barcode::where('id', $id)->first();
        $safety_option->status  = $request->input('status');
        $safety_option->update();
        return $safety_option;
    }

    public function SetBarcodes(Request $request)
    {
        $selectedBarcodes = $request->input('barcodes');
        session()->put('selected_barcodes', $selectedBarcodes);
        return response()->json(['success' => true]);
    }
    public function SetCustomerDetial()
    {
        $selectedBarcodes = session()->get('selected_barcodes');
        $selectedBarcodes = explode(',', $selectedBarcodes);
        $customerData = new User;
        $userRole = Auth::guard('admin')->user()->role;
        if ($userRole == 'SELL_EMPLOYEE') {
            $promocode = Promocode::where('assign_for', 'seller')->get();
        } else if ($userRole == 'FRANCHISE_PARTNER') {
            $promocode = Promocode::where('assign_for', 'franchise')->get();
        }
        return view('seller.customer_form', compact('customerData', 'promocode'));
    }

    public function searchCustomer(Request $request)
    {
        if ($request->input('customer_phone_no')) {
            $rules =  [
                'customer_phone_no' => 'required'
            ];
            $validatedData = $request->validate($rules);
        }

        $customerData = User::where('mobile_number', $request->input('customer_phone_no'))->first();
        $userRole = Auth::guard('admin')->user()->role;
        if ($userRole == 'SELL_EMPLOYEE') {
            $promocode = Promocode::where('assign_for', 'seller')->get();
        } else if ($userRole == 'FRANCHISE_PARTNER') {
            $promocode = Promocode::where('assign_for', 'franchise')->get();
        }
        if (!empty($customerData->mobile_number)) {
            return view('seller.customer_form', compact('customerData', 'promocode'));
        } else {
            $customerData = new User;
            $error = "No Customer Found";
            return view('seller.customer_form', compact('customerData', 'error', 'promocode'));
        }
    }

    public function sellerPromocode(Request $request)
    {
        $code = $request->code;
        $price = $request->price;
        $quantity =  $request->quantity;
        $discount =  GetDiscount($code, $quantity, $price);
        // dd($discount);
        if ($discount) {
            $total_amount = $price - $discount;
        } else {
            $total_amount = $price;
        }
        return response()->json(['discount' => $discount, 'total_amount' => $total_amount]);
    }

    public function CreateCustomer()
    {
        return view('seller.new_customer_form');
    }

    public function user_register(Request $request)
    {
        $userRole = Auth::guard('admin')->user()->role;
        $rules = [];
        if ($userRole == 'SELL_EMPLOYEE') {
            $rules = [
                'payment_method' => 'required',
            ];

            if ($request->input('payment_method') != 'Cash') {
                $rules['transaction_id'] = 'required';
            }
        }

        if ($request->has('first_name')) {
            // Validation rules for creating a customer
            $customerRules = [
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'mobile_number' => ['required', 'numeric', 'regex:/^[0-9\s\-]{10}$/', 'unique:users'],
                // 'password' => ['required', 'string', 'min:8'],
            ];

            $rules = array_merge($rules, $customerRules);
        }

        $validatedData = $request->validate($rules);

        if ($request->has('first_name')) {
            // Create a new customer
            $name = $request->input('first_name') . ' ' . $request->input('last_name');
            $UserData = User::create([
                'name' => $name,
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'mobile_number' => $request->input('mobile_number'),
            ]);

            $user_id = $UserData->id;

            // Log the creation of a customer
            $logData['admin_id'] = Auth::guard('admin')->user()->id;
            $logData['user_id'] = $user_id;
            $logData['type'] = "add_customer_by_seller";
            $logData['data'] = json_encode($UserData);
            Log::create($logData);

            $PostData =  $request->all();
            $Orderdata['name'] = $PostData['first_name'] . ' ' . $PostData['last_name'];
            $Orderdata['email'] = $PostData['email'];
            $Orderdata['mobile_number'] = $PostData['mobile_number'];
        } else {
            // Create a new order
            $Orderdata = $request->all();
            // $total_amount = $Orderdata['price'] - $Orderdata['discount'];

            $user_id = $Orderdata['user_id'];
            $UserData =  User::find($user_id);

            $Orderdata['name'] = $UserData['first_name'] . ' ' . $UserData['last_name'];
            $Orderdata['email'] = $UserData['email'];
            $Orderdata['mobile_number'] = $UserData['mobile_number'];
        }
        $PostData =  $request->all();
        $userRole = Auth::guard('admin')->user()->role;
        if ($userRole == 'SELL_EMPLOYEE') {

            $barcodes_array = explode(', ', $PostData['barcodes']);
            $wheelers = Barcode::select('wheeler_type')->whereIn('barcode', $barcodes_array)->get()->toArray();
            $types = array_column($wheelers,'wheeler_type');
            $order_details = array_count_values($types);

            $Orderdata['barcodes'] = $PostData['barcodes'];
            $Orderdata['price'] = $PostData['price'];
            $Orderdata['discount'] = $PostData['discount'];
            $Orderdata['discount'] = ($PostData['discount']) ? $PostData['discount'] : 0;
            if ($Orderdata['discount'] == 0) {
                $Orderdata['promo_code'] = '';
            } else {
                $Orderdata['promo_code'] = ($PostData['promo_code']) ? $PostData['promo_code'] : '';
            }
            $Orderdata['total_amount'] = $PostData['price'];
            $Orderdata['quantity'] = $PostData['quantity'];
            $Orderdata['user_id'] = $user_id;
            $Orderdata['payment_method'] = $PostData['payment_method'];
            $Orderdata['transaction_id'] = $PostData['transaction_id'];

            $Orderdata['financial_status'] = 'COMPLETED';
            $Orderdata['status'] = 'COMPLETED';
            $Orderdata['financial_status'] = 'COMPLETED';
            $Orderdata['status'] = 'COMPLETED';
            $Orderdata['order_id'] = Generate_Order_Id();
            $Orderdata['order_by'] = Auth::user()->id;
            $Orderdata['order_from'] = 'seller';

            $order = order::create($Orderdata);

            $barcodes_array = explode(', ', $PostData['barcodes']);
            $wheelers = Barcode::select('wheeler_type')->whereIn('barcode', $barcodes_array)->get()->toArray();
            $types = array_column($wheelers,'wheeler_type');
            $order_details = array_count_values($types);

            foreach($order_details as $k=>$item){
                $orderdata = new OrderDetails();
                $orderdata->order_id = $order['id'];
                $orderdata->wheeler_type = $k;
                $orderdata->quantity = $item;
                $orderdata->save();
            }
            // Mail::to($order->email)->send(new OrderConfirmation($order));

            $OrderHistData['admin_id'] = Auth::guard('admin')->user()->id;
            $OrderHistData['customer_id'] = $Orderdata['user_id'];
            $OrderHistData['order_id'] = $Orderdata['order_id'];
            $OrderHistData['barcode'] = $Orderdata['barcodes'];
            $OrderHistData['type'] = "order_create_admin";
            $OrderHistData['data'] = json_encode($Orderdata);
            OrderHistory::create($OrderHistData);
        }

        $barcodes = $PostData['barcodes'];
        if ($PostData['barcodes'] >= 1) {
            $barcodes_array = explode(',', $PostData['barcodes']);
            $barcodes_array = array_values(array_filter($barcodes_array));
            foreach ($barcodes_array as $code) {
                $code = str_replace(' ', '', $code);
                barcode::where('barcode', $code)->update(['customer_id' => $user_id, 'status' => 1]);
            }
        } else {
            barcode::where('barcode', $barcodes)->update(['customer_id' => $user_id, 'status' => 1]);
        }
        session()->flash('success', 'Order Created Successfully');
        if ($request->ajax()) {
            return response()->json(['redirect' => route('barcode')]);
        } else {
            return redirect()->route('barcode');
        }
    }

    public function reAssign($code)
    {
        $code = Barcode::where('code', $code)->first();
        $assignedToId = $code->assign_to ?? "";
        $role = ($code && $code->type == 'seller') ? 'SELL_EMPLOYEE' : 'FRANCHISE_PARTNER';

        $user_list = Admin::where('id', '!=', $assignedToId)
            ->whereIn('role', [$role])
            ->where('status', 1)
            ->get();
        return view('admin.barcode.reassign_barcode', compact('user_list','role'));
    }

    public function reassignList(Request $request)
    {
        if ($request->ajax()) {
            $code = $request->input('code');
            $barcodes_array = Barcode::where('code', $code)->get();

            return DataTables($barcodes_array)
                ->addColumn('checkbox', function ($data) {
                    $checked =  (!empty($data->customer)) ? 'disabled' : '';
                    $line  = '<input id="' . $data->barcode . '" type="checkbox" class="row-checkbox"' . $checked . '>';
                    $line .= '<label for="' . $data->barcode . '"  ></label>';
                    return $line;
                })
                ->addColumn('barcode', function ($data) {
                    return ucwords(($data->barcode));
                })
                ->addColumn('created_at', function ($data) {
                    return $data->created_at;
                })

                ->rawColumns(['checkbox'])
                ->make(true);
        }
    }

    public function reassignBarcode(Request $request)
    {
        $selectedtype = $request->input('selectedtype');
        $selectedValues = $request->input('selectedValues');
        $selectedStatus = $request->input('status');
        $selectedPrice = $request->input('price');

        $old_code = barcode::where('barcode', $selectedValues[0])->pluck('code')->first();

        // pre($selectedValues);
        $admin = Admin::where('id', $selectedtype)->first();
        // pre($admin->name);exit;
        // $type = ($admin->role == 'SELL_EMPLOYEE') ? 'seller' : 'franchise';

        $code = date('YmdHis');

        foreach ($selectedValues as $value) {
            barcode::where('barcode', $value)
                ->update([
                    'assign_to' => $selectedtype,
                    'status' => $selectedStatus,
                    'code' => $code,
                ]);
        }
        // pre($barcode);

        BarcodeHistories::updateOrCreate(
            [
                'assign_to' => $selectedtype,
                'code' => $code,
            ],
            [
                'count' => count($selectedValues),
            ]
        );

        $old_count = barcode::where('code', $old_code)->count();
        BarcodeHistories::where('code', $old_code)->update(['count' => $old_count]);

        if ($admin->role == 'FRANCHISE_PARTNER')
        {
            $Orderdata['name'] = $admin->name;
            $Orderdata['mobile_number'] = $admin->mobile_number;
            $Orderdata['email'] = $admin->email;
            $Orderdata['barcodes'] = implode(',', $selectedValues);
            $Orderdata['price'] = $selectedPrice;
            $Orderdata['quantity'] = count($selectedValues);

            $Orderdata['total_amount'] = $selectedPrice;

            $Orderdata['financial_status'] = 'COMPLETED';
            $Orderdata['status'] = 'COMPLETED';
            $Orderdata['financial_status'] = 'COMPLETED';
            $Orderdata['status'] = 'COMPLETED';
            $Orderdata['order_id'] = Generate_Order_Id();
            $Orderdata['order_by'] = Auth::user()->id;
            $Orderdata['order_from'] = 'franchise';

            $order = order::create($Orderdata);
            // Mail::to($order->email)->send(new OrderConfirmation($order));

            $OrderHistData['admin_id'] = Auth::guard('admin')->user()->id;
            // $OrderHistData['customer_id'] = $Orderdata['user_id'];
            $OrderHistData['order_id'] = $Orderdata['order_id'];
            $OrderHistData['barcode'] = $Orderdata['barcodes'];
            $OrderHistData['type'] = "order_create_admin";
            $OrderHistData['data'] = json_encode($Orderdata);
            OrderHistory::create($OrderHistData);

            $orderdetails['order_id'] = $order['id'];
            $orderdetails['wheeler_type'] = $old_count['wheeler_type'];
            $orderdetails['quantity'] = $old_count;
            OrderDetails::create($orderdetails);
        }
        $message = 'Barcodes Reassign updated successfully';
        return response()->json(['success' => true, 'redirect' => route('barcode')]);
    }

    public function generate_Barcode(Request $request)
    {

        $barcodeData = $request->all();
        $number = $request->number;
        $type = $request->type;
        $wheeler_type = $request->wheeler_type;

        $whereType['type'] = $type;
        $whereType['wheeler_type'] = $wheeler_type;

        $last_record = Barcode::select('barcode')->where($whereType)->orderBy('barcode', 'desc')->first();
        if ($last_record) {
            $lastBarcode = $last_record['barcode'];
            $numericPart = substr($lastBarcode, 4);
            // dd($numericPart);
            $lastRecordNumericPart = (int)$numericPart;
        } else {
            $lastRecordNumericPart = 0;
        }

        if ($request->filled('type')) {
            $data = [];
            $data[] = ['value' => 'Barcode'];
            for ($i = 0; $i < $number; $i++) {
                $lastRecordNumericPart++;
                if ($type == 'web') {
                    $prefix = ($wheeler_type == '2 Wheeler') ? 'W2RS' : 'W4RS';
                } elseif ($type == 'seller') {
                    $prefix = ($wheeler_type == '2 Wheeler') ? 'S2RS' : 'S4RS';
                } elseif ($type == 'franchise') {
                    $prefix = ($wheeler_type == '2 Wheeler') ? 'F2RS' : 'F4RS';
                } elseif ($type == 'test') {
                    $prefix = ($wheeler_type == '2 Wheeler') ? 'T2RS' : 'T4RS';
                } else {
                    $prefix = '';
                }

                if (!empty($prefix)) {
                    $barcodeValue = $prefix . str_pad($lastRecordNumericPart, 10, '0', STR_PAD_LEFT);

                    $barcodeSave = Barcode::create([
                        'barcode' => $barcodeValue,
                        'type' => $type,
                        'wheeler_type' => $wheeler_type,
                        'status' => '0',
                        'is_online_product' => ($type == 'web') ? 1 : 0,
                        'uploaded_by' => Auth::guard('admin')->user()->id
                    ]);
                    $data[] = ['value' => $barcodeValue];
                }
            }
        }

    }
}
