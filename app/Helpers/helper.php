<?php
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Models\Address;
use App\Models\barcode;
use App\Models\Discount;
use Illuminate\Support\Facades\Auth;

function pre($str) {
   echo "<pre>";
      print_r($str);
   echo "</pre>";
}

function CSSVersion($File)
{
   $filePath = public_path() . '/' . $File;
   $version = filemtime($filePath);
   return asset("{$File}?ver={$version}");
}

function JSVersion($File)
{
   $filePath = public_path() . '/' . $File;
   $version = filemtime($filePath);
   return asset("{$File}?ver={$version}");
}

function Generate_image($image)
{
    $image = SITE_URL.$image;
    $type = pathinfo($image, PATHINFO_EXTENSION);
    $data = file_get_contents($image);
    $logo = 'data:image/' . $type . ';base64,' . base64_encode($data);
    return $logo;
}

function GetInsuranceName($alias){
    $insurances = DB::table('insurances')->select('name')->where('alias',$alias)->first();
    return ($insurances) ? $insurances->name : '';
}

if (!function_exists('getRoles')) {
    function getRoles()
    {
        $role = Role::where('alias', '!=', 'SUPER_ADMIN')->where('status', 1)->orderBy('id', 'asc')->get();
        return $role;
    }
}

if (!function_exists('AdminRole')) {
    function AdminRole($alias)
    {
        $role = Role::select('name')->where('status', 1)->where('alias',$alias)->first();
        return $role->name;
    }
}

if (!function_exists('vehicleBrands')) {
    function vehicleBrands($id = '')
    {
        if($id){
            $vehicle_brands = DB::table('vehicle_brands')->where('id',$id)->orderBy('name','ASC')->first();
            return $vehicle_brands->name ?? "";
        }else{
            $vehicle_brands = DB::table('vehicle_brands')->orderBy('name','ASC')->get();
            return $vehicle_brands;
        }
    }
}


if (!function_exists('getTelecallerName')) {
    function getTelecallerName($id)
    {
        $admins = DB::table('admins')->where('id',$id)->first();
        return $admins->name;
    }
}

if (!function_exists('getadminName')) {
    function getadminName($id)
    {

        $admins = DB::table('admins')->where('id',$id)->first();
        return $admins->name;
    }
}

if (!function_exists('getadminNameWrole')) {
    function getadminNameWrole($id)
    {
        $admins = DB::table('admins')
                    ->select('admins.*','roles.name as role_name')
                    ->leftJoin('roles', 'roles.alias', '=', 'admins.role')
                    ->where('admins.id',$id)->first();
        return $admins->name.' ('.$admins->role_name.')';
    }
}

if (!function_exists('vehicleModel')) {
    function vehicleModel($id = '')
    {
        $vehicle_model = DB::table('vehicle_models')->where('id',$id)->first();
        return $vehicle_model->name ?? '';
    }
}

if (!function_exists('vehicleTypes')) {
    function vehicleTypes()
    {
        $vehicleTypes = [
            'Car',
            'Scooter',
            'Motorcycle',
            'Ambulance',
            'Bus',
            'Van',
            'Taxi',
            'Police car',
            'Fire engine',
            'Crane',
            'Forklift',
            'Tractor',
            'Recycling truck',
            'Cement mixer',
            'Dump truck',
        ];
        return $vehicleTypes;
    }
}

if (!function_exists('paymentMethods')) {
    function paymentMethods(){
        $paymentMethods = [
            'Cash','Credit Card','Debit Card','PayPal','Apple Pay','Google Pay','Bank Transfer','Cryptocurrency'
        ];
        return $paymentMethods;
    }
}

if (!function_exists('Generate_Order_Id')) {
    function Generate_Order_Id(){
        $Generate_Order_Id = 'RS_'.rand(1000, 9999).'_'. date('YmdHis');
        return $Generate_Order_Id;
    }
}

if (!function_exists('Safety_messages')) {
    function Safety_messages($vehicle_no,$msg_key = ''){
        $vehicle = DB::table('vehicles')->where('vehicle_no', $vehicle_no)->first();
        $messages = [];
        $messages['Parked Wrong'] = "Your vehicle ".$vehicle_no." is improperly parked. Please relocate your vehicle promptly. Thank you for cooperation. Sent by: RoadSathi";
        $messages['Not Locked'] = "Your vehicle ".$vehicle_no." appears to be unlocked. Please secure your vehicle to prevent theft or unauthorized access. Thanks. Sent by: Road Sathi";
        $messages['Tow Alert'] = "Your vehicle ".$vehicle_no." is scheduled for towing due to parking violations. Immediate action is required. Thanks. Sent by: Road Sathi";
        $messages['Headlight is On'] = "Your vehicle ".$vehicle_no." has its headlights left on. Please ensure to turn them off to prevent battery drainage. Thanks. Sent by: RoadSathi";
        $messages['Accident Alert'] = "There has been an accident involving the vehicle ".$vehicle_no.". Your immediate attention is crucial. Thanks. Sent by: RoadSathi";
        $messages['An Emergency'] = "This is an emergency message regarding the owner of the vehicle ".$vehicle_no.". They may require immediate assistance. Please contact them urgently. Thanks. Sent by: RoadSathi";

        if(!empty($msg_key)){
            return $messages[$msg_key];
        }else{
            return $messages;
        }
    }
}

if (!function_exists('TemplateID')) {
    function TemplateID($msg_key = ''){
        $messages = [];
        $messages['Parked Wrong'] = '1707171152431744178';
        $messages['Not Locked'] = '1707171152456038597';
        $messages['Tow Alert'] = '1707171152448509508';
        $messages['Headlight is On'] = '1707171152414048289';
        $messages['Accident Alert'] = '1707171152439214661';
        $messages['An Emergency'] = '1707171152422201905';
        return $messages[$msg_key];
    }
}



if (!function_exists('Vehicle_messages')) {
    function Vehicle_messages($vehicle_no){
        $vehicle = DB::table('vehicles')->where('vehicle_no', $vehicle_no)->first();
        $messages = "You have scanned ".$vehicle->owner_name." Road Sathi RS Safety Tag (".$vehicle_no."). You can now communicate with ".$vehicle->owner_name." by choosing one of our pre defined message.";
        return $messages;
    }
}

if (!function_exists('AvailableBarcode')) {
    function AvailableBarcode()
    {
        $wheredata['is_online_product'] = '1';
        $wheredata['status'] = '0';
        $wheredata['type'] = 'web';
        $barcode = DB::table('barcode')->select('wheeler_type',DB::raw('COUNT(*) as count'))->where($wheredata)
        ->whereIn('wheeler_type', ['2 Wheeler', '4 Wheeler'])
        ->groupBy('wheeler_type')
        ->pluck('count','wheeler_type');

        return $barcode;
    }
}


if (!function_exists('GetAddresses')) {
    function GetAddresses($where = [])
    {
        if($where){
            $where['user_id'] = Auth::user()->id;
            $addresses = Address::select('id')->where($where)->first();
            return ($addresses) ? $addresses->id : '';
        }else{
            $user_id = Auth::user()->id;
            $addresses = Address::where('user_id',$user_id)->latest()->get()->toArray();
            return ($addresses) ? $addresses : [];
        }
    }
}

if (!function_exists('GetPromoCode')) {
    function GetPromoCode($qnt,$price)
    {
        $wheredata['status'] = '1';
        $wheredata['assign_for'] = 'web';
        $Promocode = DB::table('promocodes')->where($wheredata)->get();

        $data = $active = $inactive = [];
        foreach($Promocode as $code){
            if(($code->minimum_type == 'quantity' && $code->minimum_value <= $qnt ) || ($code->minimum_type == 'flat' && $code->minimum_value <= $price) )
            {
                 $code->valid = 1;
                 $active[] = $code ;
            }else{
                $code->valid = 0;
                $inactive[] = $code ;
            }
        }
        $data = array_merge($active,$inactive);
        return $data;
    }
}

if (!function_exists('GetPromoCode1')) {
    function GetPromoCode1()
    {
        $wheredata['status'] = '1';
        $wheredata['assign_for'] = 'web';
        $codes = DB::table('promocodes')->where($wheredata)->get();
        return $codes;
    }
}

function GetDiscount($code,$qnt,$price)
{
    $code_data = $data = DB::table('promocodes')->where('code', $code)->where('status', 1)->first();
    $discount = '';
    if($code_data){
        if(($code_data->minimum_type == 'quantity' && $code_data->minimum_value <= $qnt ) || ($code_data->minimum_type == 'flat' && $code_data->minimum_value <= $price)){

            if($code_data->minimum_type == 'quantity'){
                if($code_data->discount_type == 'per'){
                    $discount = $price * ($code_data->discount_per / 100);
                }else{
                    $discount = $code_data->discount_flat;
                }
            }else{
                if($code_data->discount_type == 'per'){
                    $discount = $price * ($code_data->discount_per / 100);
                }else{
                    $discount = $code_data->discount_flat;
                }
            }
        }
    }
    return $discount;
}

if (!function_exists('price_format')) {
    function price_format($price)
    {
        return number_format($price, 2);
    }
}

if (!function_exists('product_content')) {
    function product_content(){
        $messages = [];
        $messages[] = "Any unknown individuals can scan the vehicle tag and notify the vehicle owner about various situations or occasions such as:";
        $messages[] = "Vehicle parked in the wrong place or prohibited area.";
        $messages[] = "Vehicle blocking the road or another vehicle.";
        $messages[] = "Vehicle left unlocked or with keys left on it.";
        $messages[] = "Threatening situations like fire in the parked vehicle area.";
        $messages[] = "In the event of an accident, inform the victim's family members.";
        return $messages;
    }
}

if (!function_exists('Hire_service_cab')) {
    function Hire_service_Cab(){
        $messages = [];
        $messages[] = [ 'name' => 'Reliable Service',
            'data' => [
                "Immediate Booking With Detailed Driver Information Provided.",
                "Punctual And On-Time Service, Ensuring You Reach Your Destination Without Delay."
            ]
        ];
        $messages[] = [ 'name' => 'Transparent Billing',
            'data' => [
                "Our Pricing Is Straightforward And Transparent, With No Hidden Fees.",
                "Say Goodbye To Night Charges And Extra Driver Fees."
            ]
        ];
        $messages[] = [ 'name' => 'Clean Car',
            'data' => [
                "Your Safety Is Our Priority. Our Vehicles Are Thoroughly Sanitized After Each Ride.",
                "Experience The Freshness Of A Professionally Cleaned Car Every Time You Ride With Us."
            ]
        ];
        $messages[] = [ 'name' => 'Professional Drivers',
            'data' => [
                "Rest Assured, Our Drivers Are Meticulously Verified And Extensively Trained.",
                "Our Customer-Centric Approach Ensures A Pleasant Journey With Gentle And Well-Behaved Drivers."
            ]
        ];
        $messages[] = [ 'name' => '24*7 Contact Centre Support',
            'data' => [
                "Need Assistance? Our Dedicated Support Team Is Available Around The Clock.",
                "Call Us Anytime At 987 987 5066."
            ]
        ];
        return $messages;
    }
}

if (!function_exists('Hire_service_Bus')) {
    function Hire_service_Bus(){
        $messages = [];
        $messages[] = [ 'name' => 'Terms Of Service For Bus On Rent In Ahmedabad',
            'data' => [
                "Parking, Toll Tax, Border Tax, State Permit Will Be Charged Extra On Actual.",
                "Driver Allowance Per Day – 200/- Extra, Night Charge Per Night – 100/- Extra.",
                "The Hours & KMS Are Computed From Our Ahmedabad Office To Ahmedabad Office.",
                "Tariff Will Be Changed As Per Fuel Rate Hike.",
                "All the Above Rates May Be Differ During Season / Weekend.",
                "In Case Of Cancellation Of Duty, Minimum 8hrs/80kms Will be Charged.",
                "GST Extra As Applicable.",
            ]
        ];

        return $messages;
    }
}

if (!function_exists('Contact_US')) {
    function Contact_US(){
        $messages = [];
        $messages[] = [ 'title' => 'Email Support','value' => MAIL,'link' => 'mailto:info@roadsathi.in','icon' => SITE_URL.'public/front_assets/images/mail.png'];
        $messages[] = [ 'title' => 'Contact','value' => MOBILE_NO,'link' => 'tel:8401177585','icon' => SITE_URL.'public/front_assets/images/mail_call.png'];
        $messages[] = [ 'title' => 'Location','value' => LOCATION,'link' => '','icon' => SITE_URL.'public/front_assets/images/mail_location.png'];

        return $messages;
    }
}

if (!function_exists('Generate_Barcode')) {
    function Generate_Barcode($request){

        $barcodeData = $request->all();
        $number = $request->number;
        $type = $request->type;
        $wheeler_type = $request->wheeler_type;

        $whereType['type'] = $type;
        $whereType['wheeler_type'] = $wheeler_type;

        $last_record = barcode::select('barcode')->where($whereType)->orderBy('barcode', 'desc')->first();
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

                    $barcodeSave = barcode::create([
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
            return $data;
        }
    }
}

?>
