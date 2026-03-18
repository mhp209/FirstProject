<?php

namespace App\Http\Controllers\Api\Vehicle;

use App\Http\Controllers\Controller;
use App\Models\barcode;
use App\Models\Notification;
use App\Models\setting;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleDocuments;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;

use function PHPUnit\Framework\isEmpty;

class VehicleController extends Controller
{
    public function addVehicle(Request $request)
    {
        $getdata = json_encode($request->all());
        $basePath = public_path('api/');
        if (!file_exists($basePath . '/test')) {
            mkdir($basePath . '/test', 0777, true);
        }
        $fp = fopen($basePath . '/test/form-response.txt', 'a+');
        fwrite($fp, $getdata . PHP_EOL);

        $id = $request->id;
        // dd($id);
        $validator = Validator::make($request->all(), [
            'id' => 'nullable',
            'user_id' => 'required',
            'owner_name' => 'required',
            // 'barcode' => 'unique:vehicles,barcode,' . $id . 'id',
            'vehicle_type' => 'required',
            'vehicle_no' => 'required|unique:vehicles,vehicle_no,' . $id,
            'brand' => 'required',
            'model' => 'required',
            'mobile_number' => 'required',
            'emergency_name1' => 'required',
            'relation_emg1' => 'required',
            'emergency_number1' => 'required|numeric',
        ]);
        $vehicleData =  $request->all();

        if ($validator->fails()) {
            return $response = [
                'status' => false,
                'message' => $validator->errors()->first()
            ];
        }

        $data = $request->all();
        $data['user_id'] = $request->user_id;

        $vehicleDocuments = $request->file('vehicle_documents');
        unset($data['vehicle_documents']);

        if(!empty($request->input('barcode'))){
            if(isset($request->id) && !empty($request->id)){
                $barcodeCheck = vehicle::where('barcode', $request->barcode)->where('id', '!=', $request->id)->first();
            }else{
                $barcodeCheck = vehicle::where('barcode', $request->barcode)->first();
            }

            if($barcodeCheck)
            {
                return response()->json([
                    'status'  =>  false,
                    'message' =>  'Barcode is already used.'
                ]);

            } else {
                $activebarcode = barcode::where('barcode', trim($request->barcode))->where('status', '1')->count();
                if ($activebarcode == 0) {
                    return response()->json([
                        'status'  =>  false,
                        'message' =>  'Invalid barcode'
                    ]);
                }
            }
        }

        if ($request->id) {
            $vehicle = Vehicle::where(['id' => $request->id])->first();
            if ($request->hasFile('image')) {
                // Handle image upload and update
                $uploadedImages = $_FILES['image'];
                $images = $request->file('image');

                fwrite($fp, json_encode($images) . PHP_EOL);
                $vehicleImages = [];
                foreach ($images as $key => $image) {
                    $destinationPath = VEHICLE_IMG_DIR;
                    $originalName = $image->getClientOriginalName();
                    $fileName = pathinfo($originalName, PATHINFO_FILENAME);
                    $extension = $image->getClientOriginalExtension();
                    $vehicleImage = $data['user_id'] . '_' . $fileName . '_' . date('YmdHis') . '.' . $extension;
                    $image->move($destinationPath, $vehicleImage);
                    $vehicleImages[] = $vehicleImage;
                }

                $vehicleImages_str = implode(",", $vehicleImages);
                $data['image'] = $vehicleImages_str;
                if (!empty($vehicle->image)) {
                    $data['image'] = $vehicle->image . ',' . $vehicleImages_str;
                } else {
                    $data['image'] = $vehicleImages_str;
                }
            }
            $vehicle->update($data);
            $response = array(
                'status'         => true,
                'message'        => 'Vehicle updated successfully',
            );
        } else {

            if ($request->hasFile('image')) {
                $images = $request->file('image');
                fwrite($fp, json_encode($images) . PHP_EOL);
                $vehicleImages = [];
                foreach ($images as $image) {
                    $originalName = $image->getClientOriginalName();
                    $fileName = pathinfo($originalName, PATHINFO_FILENAME);
                    $destinationPath = VEHICLE_IMG_DIR;
                    $extension = $image->getClientOriginalExtension();
                    $profileImage = $data['user_id'] . '_' . $fileName . '_' . date('YmdHis') . '.' . $extension;
                    $image->move($destinationPath, $profileImage);
                    $vehicleImages[] = $profileImage;
                }
                $vehicleImages_str = implode(",", $vehicleImages);
                $request = $request->except('image');
                $data['image'] = $vehicleImages_str;
            }

            $vehicle = Vehicle::create($data);
            $response = array(
                'status'         => true,
                'message'        => 'Vehicle created successfully',
            );
        }

        if (!is_null($vehicleDocuments)) {
            foreach ($vehicleDocuments as $value => $doc) {
                $destinationPath = VEHICLE_DIR;
                $extension = $doc->getClientOriginalExtension();
                $vehicleDoc = $value . '_' . $data['user_id'] . '_' . date('YmdHis') . '.' . $extension;
                $doc->move($destinationPath, $vehicleDoc);
                VehicleDocuments::updateOrCreate(
                    ['vehicle_id' => $vehicle->id, 'type' => $value],
                    ['name' => $vehicleDoc]
                );
            }
        }

        if ($vehicle) {
            return response()->json($response);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong! Please try again'
            ]);
        }
    }

    public function deleteVehicle($id)
    {
        $vehicle = Vehicle::where(['id' => $id])->first();
        $VehicleDocuments = $vehicle->VehicleDocuments;
        foreach ($VehicleDocuments as $documents) {
            @unlink(VEHICLE_DIR . $documents->name);
            $documents->delete();
        }
        if (!empty($vehicle->image)) {
            $images = explode(',', $vehicle->image);
            foreach ($images as $img) {
                @unlink(VEHICLE_IMG_DIR . $img);
            }
        }
        if ($vehicle) {
            if ($vehicle->delete()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Vehicle deleted successfully'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong! Please try again'
            ]);
        }
    }

    public function barcode(Request $request)
    {
        $id = $request->id;
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'barcode' => 'required|unique:vehicles,barcode,' . $id . 'id',
        ]);
        $barcodeData = $request->all();

        if ($validator->fails()) {
            return $response = [
                'status' => false,
                'message' => $validator->errors()->first()
            ];
        }

        $barcode = barcode::where('barcode', $request->barcode)->where('status', '1')->first();
        if ($barcode) {
            $vehivleBarcode = Vehicle::where(['id' => $request->id])->first();
            if (($vehivleBarcode)) {
                $vehivleBarcode = $vehivleBarcode->update($barcodeData);
                if (isEmpty($vehivleBarcode)) {
                    return response()->json([
                        'status'  => true,
                        'message' => 'Barcode update successfully',
                    ]);
                } else {
                    return response()->json([
                        'status'  =>  false,
                        'message' =>  'something went wrong! Please try again'
                    ]);
                }
            } else {
                return response()->json([
                    'status'  =>  false,
                    'message' =>  'Data not found'
                ]);
            }
        } else {
            return response()->json([
                'status'  =>  false,
                'message' =>  'Barcode is not available'
            ]);
        }
    }

    public function vehicleImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required',
            'id' => 'required',
        ]);
        $Data = $request->all();
        if ($validator->fails()) {
            return $response = [
                'status' => false,
                'message' => $validator->errors()->first()
            ];
        }
        $image_name  = $request->image;
        $id  = $request->id;
        $vehicle = Vehicle::find($id);
        // dd($vehicle->image);
        if (!empty($vehicle->image)) {
            if (stripos($vehicle->image, ',') !== false) {
                $images = explode(',', $vehicle->image);
                foreach ($images as $key => $img) {
                    if ($img == $image_name) {
                        unset($images[$key]);
                        @unlink(VEHICLE_IMG_DIR . $img);
                    }
                }
                // pre(implode(',',$images));exit;
                $vehicle->image = implode(',', $images);
                $vehicle->save();
            } else {
                @unlink(VEHICLE_IMG_DIR . $vehicle->image);
                $vehicle->image = '';
                $vehicle->save();
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data not found'
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => 'Image vehicle deleted successfully'
        ]);
    }

    public function track(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barcode' => 'required',
        ]);
        $Data = $request->all();
        if ($validator->fails()) {
            return $response = [
                'status' => false,
                'message' => $validator->errors()->first()
            ];
        }
        $vehicle = Vehicle::with('VehicleBrand', 'VehicleModel')->where('barcode', $request->barcode)->first();
        if ($vehicle) {
            $message = Vehicle_messages($vehicle->vehicle_no);
            $data['vehicle_no'] = $vehicle->vehicle_no;
            $data['owner_name'] = $vehicle->owner_name;
            $data['brand_model'] = $vehicle->VehicleBrand->name . ' ' . $vehicle->VehicleModel->name . ' ' . $vehicle->vehicle_type;
            $data['vehicle_message'] = $message;

            $Reasons = [
                'Parked Wrong', 'Not Locked', 'Tow Alert', 'Headlight is On', 'An Emergency', 'Accident Alert',
            ];

            return response()->json([
                'status' => true,
                'message' => 'Vehicle track fetch successfully',
                "data" => [
                    'Vehicle_Details' => $data,
                    'Reasons' => $Reasons
                ],
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Data not found',
            ]);
        }
    }

    public function smsTrack(Request $request)
    {
        $vehicleNO = $request->input('vehicle_no');
        $reason = $request->input('reason');
        $vehicle = Vehicle::where('vehicle_no', $request->vehicle_no)->first();

        $message = Safety_messages($vehicle->vehicle_no, $reason);

        $firebaseToken = User::where('id', $vehicle->user_id)->whereNotNull('fcm_token')->pluck('fcm_token')->all();

        $SERVER_API_KEY = env('FCM_SERVER_KEY');

        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $reason,
                "body" => $message,
            ],
            "data" => [
                "title" => $reason,
                "body" => $message,
            ]
        ];

        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);
        $dataString = json_decode($response, true);

        /* SMS Alert */
        // $message = $message;
        // $username = 'roadsathi';
        // $sendername = 'ROADSA';
        // $smstype = 'TRANS';
        // $apikey = '99abb579-e577-4436-8ae9-fd1073ea42f1';
        // $numbers = $vehicle->mobile_number;

        // $statusCode = 200;
        // $body = '[{"responseCode":"Message SuccessFully Submitted"},{"msgid":"4667111"}]';
        // $body_array = json_decode($body,1);

        // $client = new Client();
        // $url = "http://login.aquasms.com/sendSMS?username=$username&message=$message&sendername=$sendername&smstype=$smstype&numbers=$phone_no&apikey=$apikey";

        // $response = $client->get($url);
        // $statusCode = $response->getStatusCode();
        // $body = $response->getBody()->getContents();

        // $vehicleData = Vehicle::where('vehicle_no', $vehicle_no)->first();

        // $phone_no =  $vehicle['mobile_number'].','.$vehicle['emergency_number1'];
        // if(!empty($vehicle['emergency_number2']))
        //     $phone_no .= ','.$vehicle['emergency_number2'];

        // $templateId = TemplateID($reason);

        // $username = $_ENV['SMS_USERNAME'];
        // $sendername = $_ENV['SMS_SENDERNAME'];
        // $smstype = $_ENV['SMS_TYPE'];
        // $apikey = $_ENV['SMS_API_KEY'];

        // $url = "http://login.aquasms.com/sendSMS";
        // $url .= "?username=$username";
        // $url .= "&message=$message";
        // $url .= "&sendername=$sendername";
        // $url .= "&smstype=$smstype";
        // $url .= "&numbers=$phone_no";
        // $url .= "&apikey=$apikey";
        // $url .= "&template_id=$templateId";

        // Create a Guzzle client
        // $client = new Client();

        // $setting = setting::first();
        // if($setting['sms'] == 1){
        //     $response = $client->get($url);
        //     $statusCode = $response->getStatusCode();
        //     $body = $response->getBody()->getContents();
        //     $body_array = json_decode($body,1);
        //     $msgid = $body_array[1]['msgid'];
        // }else{
        //     $body = $statusCode = '';
        //     $msgid = '123';
        // }

        $notification = Notification::get();

        $notificationData = [
            'user_id' => $vehicle->user_id,
            'type'    => $reason,
            'message' => $message,
        ];
        Notification::create($notificationData);

        return response()->json([
            'status'  =>  true,
            'message' => 'Notification send successfully.',
        ]);
    }

    public function vehicleDocDestroy(Request $request)
    {
        $vehicleid = $request->input('vehicleid');
        $rcDocument = $request->input('rc_document') ? 1 : 0;
        $pucDocument = $request->input('puc_document') ? 1 : 0;
        $insDocument = $request->input('inurance_document') ? 1 : 0;

        if ($rcDocument) {
            $vehicle = VehicleDocuments::where('vehicle_id', $vehicleid)->where('type', 'rc')->delete();
        }
        if ($pucDocument) {
            $vehicle = VehicleDocuments::where('vehicle_id', $vehicleid)->where('type', 'puc')->delete();
        }
        if ($insDocument) {
            $vehicle = VehicleDocuments::where('vehicle_id', $vehicleid)->where('type', 'insurance')->delete();
        }

        return response()->json([
            'status'  =>  true,
            'message' => 'Vehicle document deleted successfully.'
        ]);
    }
}
