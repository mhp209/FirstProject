<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile_number' => ['required', 'numeric', 'regex:/^[0-9\s\-]{10}$/'],
            'password' => ['required', 'string'],
            'fcm_token' => ['required','unique:users']
        ]);

        if ($validator->fails()) {
			return $response = [
                'status' => false,
                'message' => $validator->errors()->first()
            ];
		}

        $loginData = $request->all();

        $fcm_token = $request['fcm_token'];

        if(Auth::attempt(['mobile_number' => $request->mobile_number, 'password' => $request->password, 'status'=>'1'])){
            $loginData = Auth::user();
            $request->user()->update(['fcm_token' => $fcm_token]);
            $data = [
                'token' => $loginData->createToken('token')->plainTextToken,
                'userid' => $loginData->id,
                "firstName" => $loginData->first_name ?? "" ,
                "lastName" => $loginData->last_name ?? "",
                "email" => $loginData->email ?? "",
                'mobile' => $loginData->mobile_number ?? "",
                'blood_group' => $loginData->blood_group ?? "",
            ];

            return response()->json([
                'status' => true,
                'message' => 'User signed in successfully',
                'data' => $data
            ]);
        } else{
            return response()->json([
                'status' => false,
                'message' => 'Credentials does not match.'
            ]);
        }

    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'mobile_number' => ['required', 'numeric', 'regex:/^[0-9\s\-]{10}$/','unique:users'],
            'password' => ['required', 'string', 'confirmed'],
        ]);

        if ($validator->fails()) {
			return $response = [
                'status' => false,
                'message' => $validator->errors()->first()
            ];
		}

        $signupData =  $request->all();
        $name = $signupData['first_name'] .' '. $signupData['last_name'];
        $signupData['name'] =  $name;
        $signupData['first_name'] = $signupData['first_name'];
        $signupData['last_name'] = $signupData['last_name'];
        $signupData['email'] = $signupData['email'];
        $signupData['mobile_number'] = $signupData['mobile_number'];
        $signupData['password'] = Hash::make($signupData['password']);

        $user = User::create($signupData);

        if($user){
            return response()->json([
                'status' => true,
                'message' => 'SignUp created successfully'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong! Please try again'
            ]);
        }
    }

    public function logOut(Request $request)
    {
        $user = $request->input('userid');
        $user = request()->user();
        if ($user) {
            $user->update(['fcm_token' => null]);
        }
		$user->currentAccessToken()->delete();
		return response()->json([
			'status' =>  true,
			'message' => 'Logged out successfully'
		]);
    }

}
