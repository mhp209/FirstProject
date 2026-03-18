<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use App\Models\Log;
use Validator;

class AddressController extends Controller
{   

    public function index(Request $request)
    {        
        $user_id = $request->user_id;
        $Address = Address::where('user_id',$user_id)->get();
       
        $response = array(
            'status'         => true,
            'message'        => 'Data fetch successfully',
            "data" => [
                'address' => $Address,     
            ],
        );

        return response()->json($response);
    }
    public function addAddress(Request $request)
    {        
        $rules =  [            
            'user_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile_number' => 'required|numeric|digits:10',
            'email' => 'required|email',
            'add1' => 'required',
            'pincode' => 'required|numeric',
            'state' => 'required',
            'city' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $response = [
                'status' => false,
                'message' => $validator->errors()->first()
            ];
        }
        $PostData = $request->all();

        if(isset($PostData['is_default']) && $PostData['is_default'] == 1){
            Address::where('user_id', $PostData['user_id'])->update(['is_default' => 0]);
        }
        if(isset($PostData['id']) && !empty($PostData['id'])){
            $id = $request->input('id');
            $existingAddress = Address::find($id);
            $address =  $existingAddress->update($PostData);
            $add_id = $id;
            $logData['type'] = "update_address_apk";
            $msg = 'Address successfully updated';
        }else{
            $address = Address::create($PostData);
            $add_id = $address->id;
            $logData['type'] = "add_address_apk";
            $msg = 'Address successfully Added.';
        }

        $PostData['user_id'] = Auth::user()->id;
        $logData['data'] = json_encode($PostData);
        Log::create($logData);

        $response = array(
            'status'         => true,
            'message'        => $msg,
        );
       
        if ($address) {
            return response()->json($response);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong! Please try again'
            ]);
        }
    }

    public function delete($id)
    {
        $address = Address::find($id);       
        if ($address) {
            if ($address->delete()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Address deleted successfully'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong! Please try again'
            ]);
        }
    }

}
