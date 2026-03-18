<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class ResetPasswordController extends Controller
{
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile_number' => ['required', 'numeric', 'regex:/^[0-9\s\-]{10}$/'],
            'password' => ['required', 'string', 'confirmed'],
            'password_confirmation' => ['required'],
        ]);

        if ($validator->fails()) {
			return $response = [
                'status' => false,
                'message' => $validator->errors()->first()
            ];
		}

        $passwordData = $request->all();

        $user = User::where(['mobile_number' => $passwordData['mobile_number']])->first();
        if (isset($user)) {
            if (!empty($user)) {
                if (Hash::check($request->password, $user['password'])) {
                    return response([
                        'status' => false,
                        'message' => 'New password and Current password must be different'
                    ]);
                }
                $userArray['password'] = Hash::make($passwordData['password']);
                if ($user->update($userArray)) {
                    return response()->json([
                        'status' => true,
                        'message' => 'Reset password successfully'
                    ]);
                }
            }
        }
        return response()->json([
            'status' =>  false,
            'message' => 'User data not found'
        ]);
    }
}
