<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\ReminderDate;
use App\Models\User;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class NotificationController extends Controller
{
    public function notification(Request $request)
    {
        $user = $request->input('userid');
        $notification = Notification::where('user_id', $user)->get();

        if (!$notification->isEmpty()) {
            foreach ($notification as $item) {
                $data['message'] = $item->message ?? '';
                $data['time'] = date('Y-m-d H:i:s', strtotime($item->created_at)) ?? '';
                $data['isRead'] = $item->is_read ?? '';
                $notificationsArray[] = $data;
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data not found',
            ]);
        }

        $response = array(
            'status'    =>  true,
            'message'   => 'Data fetch successfully',
            'data'      =>  $notificationsArray,
        );

        return response()->json($response);
    }

    public function reminder(Request $request)
    {
        $Data = $request->all();

        $user = Auth::user()->id;
        $vehicleId = $request->input('vehicle_id');
        $lcExpiryDate = $request->input('license_ending_date') ? 1 : 0;
        $pucExpiryDate = $request->input('puc_ending_date') ? 1 : 0;
        $insExpiryDate = $request->input('inurance_ending_date') ? 1 : 0;

        $rdate = date("Y-m-d", strtotime("+10 days"));

        // $vehivleBarcode = Vehicle::where('user_id', $user)->where(['license_ending_date' => $request->license_ending_date])->whereDate('license_ending_date', $date )->get();
        // $users = Vehicle::whereDate('license_ending_date', now()->addDays(5))->get();

        // $vehicleBarcode = Vehicle::where('user_id',$user)->select('license_ending_date','puc_ending_date','inurance_ending_date')->get()->toArray();
        $vehicle = Vehicle::where('user_id',$user)->get()->toArray();
        $reminderdata = [];
        foreach($vehicle as $data ){
            if( $data['license_ending_date'] == $rdate ){
                $reminderdata[] = $data['license_ending_date'];
            }

            if( $data['puc_ending_date'] == $rdate){
                $reminderdata[] = $data['puc_ending_date'];
            }

            if( $data['inurance_ending_date'] == $rdate){
                $reminderdata[] = $data['inurance_ending_date'];
            }
        }

        $reminder = ReminderDate::updateOrCreate(
            ['vehicle_id' => $vehicleId],
            ['user_id' => Auth::user()->id,
            'license_expiry_date_reminder' => $lcExpiryDate,
            'puc_expiry_date_reminder' => $pucExpiryDate,
            'insurance_expiry_date_reminder' => $insExpiryDate
        ]);
        if($reminder){
            return response()->json([
                'status'  =>  true,
                'message' => 'Date reminder successfully',
            ]);
        } else {
            return response()->json([
                'status'  =>  false,
                'message' => 'Data not found',
            ]);

        }

    }

    public function sendNotification(Request $request)
    {
        // $Data = $request->all();
        $type = $request->input('type1');
        // $message = $request->input('body');

        $firebaseToken = User::whereNotNull('fcm_token')->pluck('fcm_token')->all();

        $SERVER_API_KEY = env('FCM_SERVER_KEY');

        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $type,
                "body"  => "Hello, Welcome To Road Sathi",
            ],
            "data" => [
                "title" => $type,
                "body"  => "Hello, Welcome",
                "data"  => "Lorem ipsum"
            ]

        ];
        // dd($data);
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
        // dd($response);
        // $notification = Notification::get();

        // $notificationData = [
        //     'user_id' => Auth::user()->id,
        //     'type' => $type,
        //     'message' => $message,
        // ];
        // Notification::create($notificationData);

        return response()->json([
            'status'  =>  true,
            'message' => 'Notification send successfully.',
            'data'    =>  $dataString
        ]);

    }
}
