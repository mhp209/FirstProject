<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Vehicle;
use App\Models\Discount;
use App\Models\VehicleDocuments;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = $request->input('userid');
        $banner = Banner::where(['status' => '1'])->get();
        $vehicle = Vehicle::with('VehicleDocuments','ReminderDate','VehicleBrand','VehicleModel')->where('user_id', $user)->get();

        $bannersArray = [];
        if ($banner) {
            foreach ($banner as $item) {
                $data['id'] = $item->id ?? '';
                $data['image'] = VEHICLE_BARCODE_IMR_URL.$item->image ?? '';
                $bannersArray[] = $data;
            }
        }
        $vehicleArray = [];
        if(count($vehicle) > 0){
            foreach ($vehicle as $item) {
                $VehicleDocuments = [];
                foreach($item->VehicleDocuments as $doc){
                    $VehicleDocuments[$doc['type']] = VEHICLE_URL.$doc['name'];
                }
                // dd($VehicleDocuments);
                $img = [];
                if(!empty($item->image)){
                    $images = explode(',',$item->image);
                    foreach($images as $image){
                        $img[] = VEHICLE_IMG_URL.$image;
                    }
                }
                $data['id'] = $item->id ?? '';
                $data['owner_name'] = $item->owner_name ?? '';
                $data['barcode'] = $item->barcode ?? '';
                $data['image'] = $img ?? '';
                $data['vehicletype'] = $item->vehicle_type ?? '';
                $data['brand'] = $item->brand ?? '';
                $data['brand_name'] = $item->VehicleBrand->name ?? '';
                $data['model'] = $item->model ?? '';
                $data['model_name'] = $item->VehicleModel->name ?? '';
                $data['mobile'] = (string)$item->mobile_number ?? '';
                $data['vehicle_no'] = $item->vehicle_no ?? '';
                $data['rcNumber'] = $item->rc_no ?? '';
                $data['licenseNumber'] = $item->license_no ?? '';
                $data['emergency_name1'] = $item->emergency_name1 ?? '' ;
                $data['relation_emg1'] = $item->relation_emg1 ?? '';
                $data['emergency_number1'] = (string)$item->emergency_number1 ?? '';
                $data['emergency_name2'] = $item->emergency_name2 ?? '';
                $data['relation_emg2'] = $item->relation_emg2 ?? '';
                $data['emergency_number2'] = (string)$item->emergency_number2 ?? '';
                $data['licenseExpiryDate'] = $item->license_ending_date ?? '';
                $data['insuranceExpiryDate'] = $item->inurance_ending_date ?? '';
                $data['pucExpiryDate'] = $item->puc_ending_date ?? '';
                $data['serviceDate'] = $item->service_date ?? '';
                $data['licenseExpiryDateRemainder'] = $item->ReminderDate->license_expiry_date_reminder ?? 0;
                $data['insuranceExpiryDateRemainder'] = $item->ReminderDate->insurance_expiry_date_reminder ?? 0;
                $data['pucExpiryDateRemainder'] = $item->ReminderDate->puc_expiry_date_reminder ?? 0;
                $data['rc'] = $VehicleDocuments['rc'] ?? '';
                $data['insurance'] = $VehicleDocuments['insurance'] ?? '';
                $data['puc'] = $VehicleDocuments['puc'] ?? '';
                $vehicleArray[] = $data;
            }
        }

        $productContent = 'Any unknown individuals can scan the vehicle tag and notify the vehicle owner about various situations or occasions such as:'. "\n\n";
        $productContent .= '✅  Vehicle parked in the wrong place or prohibited area.'. "\n\n";
        $productContent .= '✅  Vehicle blocking the road or another vehicle.'. "\n\n";
        $productContent .= '✅  Vehicle left unlocked or with keys left on it.'. "\n\n";
        $productContent .= '✅  Threatening situations like fire in the parked vehicle area.'. "\n\n";
        $productContent .= '✅  In the event of an accident, inform the victims family members.';

        $product_image = SITE_URL.'public/front_assets/images/RS-Safety-Tag.png';
        $product_content = $productContent;
        $insurance_name = 'Insurance';
        $insurance_image = API_INSURANCE_IMAGE;
        $hire_cab = SITE_URL.'public/front_assets/images/hireCab.png';
        $hire_bus = SITE_URL.'public/front_assets/images/hireBus.png';
        $hire_Content_cab = Hire_service_Cab();
        $hire_Content_bus = Hire_service_Bus();

        $response = array(
            'status'         => true,
            'message'        => 'Data fetch successfully',
            "data" => [
                'banner' => $bannersArray,
                'vehicle' => $vehicleArray,
                'Product_Price' => RS_SAFETY_PRICE,
                'Product_name' => 'RS Safety Tag',
                'product_image' => $product_image,
                'Product_content' => $product_content,
                'Insurance_Name' => $insurance_name,
                'Insurance_Image' => $insurance_image,
                'Hire_Cab_Name' => 'Hire Cab',
                'Hire_Bus_Name' => 'Hire Bus',
                'Hire_Cab' => $hire_cab,
                'Hire_Bus' => $hire_bus,
                'Hire_Content_Cab' => $hire_Content_cab,
                'Hire_Content_Bus' => $hire_Content_bus,
            ],
        );

        return response()->json($response);
    }

    public function discount(Request $request)
    {
        $Discount = Discount::first();
        if($Discount){
            $discount = $Discount->discount;
            $quantity = $Discount->quantity;
        }else{
            $discount = '';
            $quantity = '';
        }

        $response = array(
            'status'         => true,
            'message'        => 'Discount fetch successfully',
            "data" => [
                'Product_Price' => RS_SAFETY_PRICE,
                'quantity' => (string)$quantity,
                'discount' => (string)$discount,
                'available_quantity' => (string)AvailableBarcode(),
            ],
        );

        return response()->json($response);
    }
}
