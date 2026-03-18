<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\RegisterConfirmation;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\setting;


use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;

use App\Models\Log;
use Illuminate\Support\Facades\Mail;

// use Illuminate\Foundation\Auth\RegistersUsers;
// use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    // use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::VEHICLES;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validate request
        $request->validate([
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'mobile_number' => ['required', 'numeric', 'regex:/^[0-9\s\-]{10}$/','unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ],
            [
                'mobile_number.unique'=> 'Mobile number is already registered',
            ]
        );

        // Mail::to($request->email)->send(new RegisterConfirmation($oder));


        $verificationCode = rand(1000, 9999);
        // $request->session()->put('verification_code', $verificationCode);
        // $request->session()->put('user_data', $request->all());

        $userData = $request->all();
        $userData['verification_code'] = $verificationCode;
        Session::put('verification_code', $verificationCode);
        Session::put('user_data', $userData);

        /* OTP Mail Verify*/
        try {

            $res = Mail::send('mail.OTP_Mail', array(
                'first_name' => $userData['first_name'],
                'last_name' => $userData['last_name'],
                'OTP' => $verificationCode
            ), function ($message) use ($userData) {
                $message->to($userData['email'])->subject('OTP Verification');
            });
            // pre($res);
        } catch (\Exception $e) {
            logger()->error('Error sending email: ' . $e->getMessage());
            // pre("Email is not sent ") . $e->getMessage();
        }


        /* SMS Send */
        $username = $_ENV['SMS_USERNAME'];
        $sendername = $_ENV['SMS_SENDERNAME'];
        $smstype = $_ENV['SMS_TYPE'];
        $apikey = $_ENV['SMS_API_KEY'];

        // $message = 'Hi, Your one time password for new user registration is '.$verificationCode.' Sent by: RoadSathi';
        // $templateId = "1707170550100802598";
        $message = 'Hi, Your one time password for new user registration is '.$verificationCode.'. Thanks. Sent by: RoadSathi';
        $templateId = "1707171145245496494";
        $phone_no = $userData['mobile_number'];

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
            if($setting['sms'] == 1){
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
        // session()->flash('success', 'Please check your email for OTP.');
        return Redirect::back()->with(['verification_code' => $verificationCode])->withInput();
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'mobile_number' => ['required', 'numeric', 'regex:/^[0-9\s\-]{10}$/','unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $name = $data['first_name'] .' '. $data['last_name'];
        return User::create([
            'name' => $name,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => strtolower($data['email']),
            'password' => Hash::make($data['password']),
            'mobile_number' => $data['mobile_number'],
        ]);
    }

    public function showVerificationForm()
    {
        return view('auth.verify');
    }

    public function verify(Request $request)
    {
        // Validate request
        $request->validate([
            'code' => 'required|numeric',
        ]);
        $user_data = Session::get('user_data');
        $storedCode = $user_data['verification_code'];

        if ($request->input('code') == $storedCode) {
            unset($user_data['verification_code']);
            $user = $this->create($user_data);

            $logData['user_id'] = $user->id;
            $logData['type'] = "customer_create";
            $logData['data'] = json_encode($user_data);
            Log::create($logData);

            try {
                Mail::send('mail.register_mail', array(
                    'first_name' => $user_data['first_name'],
                    'last_name' => $user_data['last_name'],
                ), function ($message) use ($user_data) {
                    $message->to($user_data['email'])->subject('Registration Confirmation');
                });
            } catch (\Exception $e) {
                logger()->error('Error sending email: ' . $e->getMessage());
            }

            Auth::login($user);
            $request->session()->forget('verification_code');
            return redirect()->route('home');
        } else {
            $request->session()->forget('verification_code');
            return back()->withErrors(['code' => 'Invalid verification code']);
        }
    }



    protected function createUser($data)
    {
        // Create user logic (customize based on your user model)
        return User::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            // Add any additional fields as needed
        ]);
    }
}
