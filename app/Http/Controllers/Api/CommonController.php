<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HireEnquiry;
use App\Models\Notification;
use App\Models\setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Validator;
use GuzzleHttp\Client;
use App\Models\Log;


class CommonController extends Controller
{
    public function sendOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile_number' => ['required', 'numeric', 'regex:/^[0-9\s\-]{10}$/'],
        ]);

        if ($validator->fails()) {
            return $response = [
                'status' => false,
                'message' => $validator->errors()->first()
            ];
        }

        $otpData =  $request->all();
        // dd($otpData);
        $verificationCode = rand(1000, 9999);
        $otp = $verificationCode;

        $userOtp = $otpData['mobile_number'];
        $userOtp = $otpData['email'];
        // $user = User::where('mobile_number', $userOtp)->first();
        // dd($userOtp);

        try {
            $res = Mail::send('mail.OTP_Mail', array(
                'first_name' => $otpData['first_name'],
                'last_name' => $otpData['last_name'],
                'OTP' => $verificationCode
            ), function ($message) use ($otpData) {
                $message->to($otpData['email'])->subject('OTP Verification');
            });
        } catch (\Exception $e) {
            logger()->error('Error sending email: ' . $e->getMessage());
            // pre("Email is not sent ") . $e->getMessage();
        }

        /* SMS Send */
        $username = $_ENV['SMS_USERNAME'];
        $sendername = $_ENV['SMS_SENDERNAME'];
        $smstype = $_ENV['SMS_TYPE'];
        $apikey = $_ENV['SMS_API_KEY'];

        $message = 'Hi, Your one time password for new user registration is ' . $verificationCode . '. Thanks. Sent by: RoadSathi';
        $templateId = "1707171145245496494";
        $phone_no = $otpData['mobile_number'];

        $url = "http://login.aquasms.com/sendSMS";
        $url .= "?username=$username";
        $url .= "&message=$message";
        $url .= "&sendername=$sendername";
        $url .= "&smstype=$smstype";
        $url .= "&numbers=$phone_no";
        $url .= "&apikey=$apikey";
        $url .= "&template_id=$templateId";

        $client = new Client();
        try {
            $setting = setting::first();
            if ($setting['sms'] == 1) {
                $response = $client->get($url);

                $statusCode = $response->getStatusCode();
                $body = $response->getBody()->getContents();

                \Log::info("SMS API Response - Status Code: $statusCode, Body: $body");
            }
        } catch (\Exception $e) {
            $statusCode = $e->getResponse()->getStatusCode();
            $body = $e->getResponse()->getBody()->getContents();
            return back()->withErrors(['code' => 'Invalid verification code']);
        }

        if ($userOtp) {
            $response = [
                'data'           => array('otp' => $otp),
                'status'         => true,
                'message'        => 'OTP has been sent successfully'
            ];
        } else {
            $response = [
                'status'         => false,
                'message'        => 'User mobile number not found'
            ];
        }

        return response()->json($response);
    }

    /* Hire Cab and Bus store */
    public function hire_store(Request $request)
    {
        $rules =  [
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile_number' => 'required',
            'email' => 'required',
            'pickup_city' => 'required',
            'dest_city' => 'required',
            'hire_name' => 'required',
            'trip_type' => 'required',
            'type_vehicle' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $response = [
                'status' => false,
                'message' => $validator->errors()->first()
            ];
        }

        $PostData = $request->all();
        $PostData['status'] = 'Open';

        if ($PostData['hire_name'] === 'Hire Cab') {
            $PostData['hire_name'] = 'hire_cab';
        } elseif ($PostData['hire_name'] === 'Hire Bus') {
            $PostData['hire_name'] = 'hire_bus';
        }
        $hire_Enquiry = HireEnquiry::create($PostData);
        if ($hire_Enquiry) {
            $message = ($hire_Enquiry['hire_name'] == 'hire_cab') ? 'Cab enquiry submitted successfully' : 'Bus enquiry submitted successfully';
            return response()->json([
                'status'  =>  true,
                'message' => $message,
            ]);
        } else {
            return response()->json([
                'status'  =>  false,
                'message' => 'Something went wrong! Please try again'
            ]);
        }
    }

    public function contactUs()
    {
        $email = Contact_US();
        $response = array(
            'status'   => true,
            'message'  => 'Contact us fetch successfully',
            "data"     => $email,
        );

        return response()->json($response);
    }

}
