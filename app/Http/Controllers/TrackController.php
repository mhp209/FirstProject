<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Support\Facades\Schema;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\SafetyOption;
use App\Models\SmsAlert;
use App\Models\setting;
use App\Models\User;
use Auth;
use GuzzleHttp\Client;

class TrackController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($barcode)
    {
        $vehicleData = Vehicle::where('barcode', $barcode)->first();
        if($vehicleData){
            $safety_reasons = SafetyOption::where('status',1)->get();
            return view('front/vehicle/track',compact('vehicleData','safety_reasons'));
        }
        if(!$vehicleData){
            // return abort(404);
            return view('404');
        }
    }
    /* Send SMS */
    public function sendSms(Request $request)
    {
        $message_key = $request->input('message_key');
        $vehicle_no = $request->input('vehicle_no');

        $vehicleData = Vehicle::select('mobile_number','emergency_number1','emergency_number2')->where('vehicle_no', $vehicle_no)->first();

        $phone_no =  $vehicleData['mobile_number'].','.$vehicleData['emergency_number1'];
        if(!empty($vehicleData['emergency_number2']))
            $phone_no .= ','.$vehicleData['emergency_number2'];

        $message = Safety_messages($vehicle_no, $message_key);
        $templateId = TemplateID($message_key);

        $username = $_ENV['SMS_USERNAME'];
        $sendername = $_ENV['SMS_SENDERNAME'];
        $smstype = $_ENV['SMS_TYPE'];
        $apikey = $_ENV['SMS_API_KEY'];

        $url = "http://login.aquasms.com/sendSMS";
        $url .= "?username=$username";
        $url .= "&message=$message";
        $url .= "&sendername=$sendername";
        $url .= "&smstype=$smstype";
        $url .= "&numbers=$phone_no";
        $url .= "&apikey=$apikey";
        $url .= "&template_id=$templateId";

        // Create a Guzzle client
        $client = new Client();

        $setting = setting::first();
        if($setting['sms'] == 1){
            $response = $client->get($url);
            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();
            $body_array = json_decode($body,1);
            $msgid = $body_array[1]['msgid'];
        }else{
            $body = $statusCode = '';
            $msgid = '123';
        }
        \Log::info("SMS API Response - Status Code: $statusCode, Body: $body");

        $statusCode = 200;
        $vehicle_data = Vehicle::where('vehicle_no',$vehicle_no)->first();
        $SmsAlertData = [
            'message_id' => $msgid,
            'user_id' => $vehicle_data['user_id'],
            'vehicle_id' => $vehicle_data['id'],
            'mobile_number' => $vehicle_data['mobile_number'],
            'vehicle_no' => $vehicle_no,
            'type' => $message_key,
            'message' => $message,
            'device' => $_SERVER["HTTP_USER_AGENT"]
        ];
        SmsAlert::create($SmsAlertData);

        $firebaseToken = User::where('id', $vehicle_data->user_id)->whereNotNull('fcm_token')->pluck('fcm_token')->all();

        if(!empty($firebaseToken)){
            $SERVER_API_KEY = env('FCM_SERVER_KEY');

            $data = [
                "registration_ids" => $firebaseToken,
                "notification" => [
                    "title" => $message_key,
                    "body" => $message,
                ],
                "data" => [
                    "title" => $message_key,
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

            $notification = Notification::get();

            $notificationData = [
                'user_id' => $vehicle_data['user_id'],
                'type'    => $message_key,
                'message' => $message,
            ];
            Notification::create($notificationData);
        }
        return response()->json(['status' => 'success' ,'result' =>  $body, 'whatsupMassage' => $message ,'safety_option' => $message_key ]);
    }

    public function GetSafetyMessage($id)
    {
        $safety_opt = SafetyOption::select('message')->where('id',$id)->first();
        return response()->json(['message' =>  $safety_opt->message]);
    }

    function sendSMS1($mobileNumbers, $message)
    {
        $username = 'roadsathi';
        $sendername = 'ROADSA';
        $smstype = 'TRANS';
        $apikey = '99abb579-e577-4436-8ae9-fd1073ea42f1';

        $url = "http://login.aquasms.com/sendSMS?username=$username&message=$message&sendername=$sendername&smstype=$smstype&numbers=$mobileNumbers&apikey=$apikey";

        // Create a Guzzle client
        $client = new Client();

        try {
            $response = $client->get($url);

            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();

            \Log::info("SMS API Response - Status Code: $statusCode, Body: $body");

            return $body;
        } catch (\Exception $e) {
            // Handle the exception, log, or return an error response
            \Log::error("SMS API Error: " . $e->getMessage());
            return false;
        }
    }

    // $result = sendSMS($mobileNumbers, $message);

    // if ($result) {
    //     echo "SMS sent successfully!";
    // } else {
    //     echo "Failed to send SMS!";
    // }

    /* Send SMS */
    public function sendMessage(Request $request)
    {
        $phone_no = $request->input('phone_no');
        $message_id = $request->input('message_id');
        $safety_opt = SafetyOption::select('message','reason_option')->where('id',$message_id)->first();
        $htmlMessage = $safety_opt->message;

        $textMessage = strip_tags($htmlMessage);
        $textMessage = html_entity_decode($textMessage, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        $url = 'https://graph.facebook.com/v18.0/126159250591738/messages';
        $accessToken = 'EAADZC308AX7gBOyb1fPb9V6kLZAeohDGlFj4TUk8oWKnPDtqWCFQONbNxfk1npbZAITO9jJzjA6lkw0I4OSF1CElJZAm2UxwZADtk2lMwHXq8jZB4MfJsjdKerGFXOz6TKW9eoZCzjZAqC3ZAZAVZAaK8ZAy8MsczGiM5JimJbRBuEkv049AvX0jrZAZAG5jAI6YhETPZA8hT6YatS6MxZC0EZBmrpz0ZD';
        $to = '+918671878940';
        $client = new Client();

        try {

            // $response = $client->post($url, [
            //     'headers' => [
            //         'Authorization' => 'Bearer ' .$accessToken,
            //         'Content-Type' => 'application/json',
            //     ],
            //     'json' => [
            //         'messaging_product' => 'whatsapp',
            //         'recipient_type' => 'individual',
            //         'to' => $to,
            //         'type' =>  'template',
            //         'template' => [
            //             'name' => 'road',
            //             'language' => [
            //                 'code' => 'en_US',
            //             ],
            //             'components' => [
            //                 [
            //                     'type' => 'body',
            //                     'parameters' => [
            //                         [
            //                             'type' => 'text',
            //                             'text' => $textMessage,
            //                         ],
            //                     ],
            //                 ],
            //             ],

            //         ]
            //     ],

            //     // 'json' => [
            //     //     'messaging_product' => 'whatsapp',
            //     //     'recipient_type' => 'individual',
            //     //     'to' => '+918671878940',
            //     //     'type' =>  'text',
            //     //     'text' => [
            //     //         'preview_url' => false,
            //     //         'body' => 'Test'
            //     //     ]
            //     // ],
            // ]);

            // $statusCode = $response->getStatusCode();
            // $body = $response->getBody()->getContents();

            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://wasend.iaas.africa/api/create-message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'appkey' => 'a66f6311-9777-4675-8a07-52d4ff13ec10',
                'authkey' => '09HU9lHxN8Eq6n7hdMOMPIa1sXsbJ6ffjtV4oiLXHanoUGjtIS',
                'to' => '918671878940',
                'message' => $textMessage,
                'sandbox' => 'false'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            echo $response;

            // echo "success";
            return response()->json(['status' => 'success' ,'result' =>  $response, 'whatsupMassage' => $htmlMessage ,'safety_option' => $safety_opt->reason_option ]);
            exit;
            // Handle the response as needed
            // You can use $statusCode and $body here
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            // Handle request exception
            $statusCode = $e->getResponse()->getStatusCode();
            $body = $e->getResponse()->getBody()->getContents();
            // pre($body);
            return response()->json(['status' => 'error' ,'result' =>  $body,'whatsupMassage' => $htmlMessage, 'safety_option' => $safety_opt->reason_option]);
            exit;
        }
    }
    public function sendWhatsAppMessage()
    {
        $url = 'https://graph.facebook.com/v18.0/126159250591738/messages';
        $accessToken = 'EAADZC308AX7gBOyb1fPb9V6kLZAeohDGlFj4TUk8oWKnPDtqWCFQONbNxfk1npbZAITO9jJzjA6lkw0I4OSF1CElJZAm2UxwZADtk2lMwHXq8jZB4MfJsjdKerGFXOz6TKW9eoZCzjZAqC3ZAZAVZAaK8ZAy8MsczGiM5JimJbRBuEkv049AvX0jrZAZAG5jAI6YhETPZA8hT6YatS6MxZC0EZBmrpz0ZD';

        $client = new Client();

        try {

            $response = $client->post($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' .$accessToken,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'messaging_product' => 'whatsapp',
                    'recipient_type' => 'individual',
                    'to' => '+918671878940',
                    'type' =>  'template',
                    'template' => [
                        'name' => 'road',
                        'language' => [
                            'code' => 'en_US',
                        ],
                        'components' => [
                            [
                                'type' => 'body',
                                'parameters' => [
                                    [
                                        'type' => 'text',
                                        'text' => 'Monika',
                                    ],
                                ],
                            ],
                        ],

                    ]
                ],

                // 'json' => [
                //     'messaging_product' => 'whatsapp',
                //     'recipient_type' => 'individual',
                //     'to' => '+918671878940',
                //     'type' =>  'text',
                //     'text' => [
                //         'preview_url' => false,
                //         'body' => 'Test'
                //     ]
                // ],
            ]);

            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();
            echo "success";
            pre($body);
            // Handle the response as needed
            // You can use $statusCode and $body here
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            // Handle request exception
            $statusCode = $e->getResponse()->getStatusCode();
            $body = $e->getResponse()->getBody()->getContents();
            pre($body);
            // Handle the error response
        }
    }
    /* Admin Alert Table */
    public function AlertList(Request $request)
    {
        if ($request->ajax()) {

            $toDate ='';
            $fromDate ='';
            if($request->input('date_range') !=''){
                $dtRangeArr=explode(' to ', $request->input('date_range'));
                $fromDate=(isset($dtRangeArr[0]))?$dtRangeArr[0]:'';
                $toDate=(isset($dtRangeArr[1]))?$dtRangeArr[1]:'';
            }

            $wherestr = "sms_alerts.id !=''";
            if($fromDate!='' && $toDate ==''){
                $wherestr .= "AND DATE(sms_alerts.created_at) ='".$fromDate."' ";
            }
            else if($fromDate!='' && $toDate !='')
            {
                $wherestr .= "AND DATE(sms_alerts.created_at) >='".$fromDate."' ";
            }

            if($toDate!=''){
                $wherestr .= " AND DATE(sms_alerts.created_at) <='".$toDate."' ";
            }

            $data = SmsAlert::whereRaw($wherestr)
                                ->orderBy('created_at','desc')
                                ->get();

            return DataTables($data)
                ->addColumn('created_at', function ($data) {
                    return $data->created_at;
                })
                ->addColumn('action', function ($data) {
                    $action_line = '<a class="action_icon view_alert" data-id="'.$data->id .'" title="View"><i class="fa fa-eye"></i></a>';
                    return $action_line;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin/alert/list');
    }
    /* Admin View Page */
    public function view(string $id)
    {
        $Alert = SmsAlert::where('id',$id)->first();
        $page = view('admin.alert.view',compact('Alert'))->render();
        return response()->json(['page' => $page]);
    }
}
