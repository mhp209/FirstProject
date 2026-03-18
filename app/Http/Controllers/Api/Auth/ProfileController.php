<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class ProfileController extends Controller
{
    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'alpha', 'max:255'],
            'last_name' => ['required', 'string', 'alpha', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'blood_group' => ['nullable'],
        ]);

        if ($validator->fails()) {
			return $response = [
                'status' => false,
                'message' => $validator->errors()->first()
            ];
		}

        $signupData =  $request->all();
        $signupData['name'] = $signupData['first_name'] .' '. $signupData['last_name'];

        $data = [
            'firstName' => $signupData['first_name'] ?? '',
            'lastName'=> $signupData['last_name'] ?? '',
            'email' => $signupData['email'] ?? '',
            'blood_group' => $signupData['blood_group'] ?? '',
        ];

        $user = User::find(Auth::user()->id);
        if ($user->update($signupData)) {
            return response()->json([
                'status'  => true,
                'message' => 'Profile updated successfully',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status'  =>  false,
                'message' =>  'something went wrong! Please try again'
            ]);
        }
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile_number' => ['required', 'numeric', 'regex:/^[0-9\s\-]{10}$/'],
            'old_password' => ['required', 'string'],
            'password' => ['required', 'string', 'confirmed'],
            'password_confirmation' => ['required'],
        ]);

        if ($validator->fails()) {
			return $response = [
                'status' => false,
                'message' => $validator->errors()->first()
            ];
		}

        $user = $request->user();
        if (Hash::check($request->old_password, $user->password)) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
            return response()->json([
                'status' =>  true,
                'message' => 'Password successfully updated'
            ]);
        } else {
            return response()->json([
                'status' =>  false,
                'message' => 'Current password does not matched'
            ]);
        }
    }
}
