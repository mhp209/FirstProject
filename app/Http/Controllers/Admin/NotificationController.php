<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        return view('admin.notification.form');
    }

    public function store(Request $request)
    {
        $Data = $request->all();
        // dd($Data);
        $type = $request->input('type');
        $message = $request->input('message');

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
                "body"  => $message,
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
        $notification = Notification::get();

        $notificationData = [
            'user_id' => Auth::user()->id,
            'type' => $type,
            'message' => $message,
        ];
        Notification::create($notificationData);

        return redirect()->back()->with('success', 'Notification send successfully.');
        // return response()->json([
        //     'status'  =>  true,
        //     'message' => 'Notification send successfully.',
        //     'data'    =>  $dataString
        // ]);

    }
}
