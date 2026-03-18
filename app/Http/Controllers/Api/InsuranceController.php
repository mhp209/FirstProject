<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Insurance;
use App\Models\Insurance_Enquiry;
use Illuminate\Http\Request;
use Validator;

class InsuranceController extends Controller
{
    public function insuranceList(Request $request)
    {
        $insurance = Insurance::where(['status' => '1'])->get();

        $insuranceArray = [];
        if (!$insurance->isEmpty()) {
            foreach ($insurance as $item) {
                $data['id'] = $item->id ?? '';
                $data['name'] = $item->name ?? '';
                $data['alias'] = $item->alias ?? '';
                $data['image'] = INSURANCE_IMAGE.$item->image ?? '';
                $insuranceArray[] = $data;
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data not found',
            ]);
        }

        return response()->json([
            'status'  =>  true,
            'message' => 'Insurance fetch successfully',
            'data'    =>  $insuranceArray
        ]);
    }

    public function addInsurance(Request $request)
    {
        $id = $request->input('id');
        $rules =  [
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile_number' => 'required|numeric|digits:10',
            'email' => 'required|email',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $response = [
                'status' => false,
                'message' => $validator->errors()->first()
            ];
        }
        $PostData = $request->all();

        $PostData['message'] = $request->message;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $destinationPath = public_path('uploads/InsuranceEnqImage');
            $profileImage = date('YmdHis') . '.' . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $PostData['image'] =   $profileImage;
        }

        $insurance = Insurance::select('alias')->where('id', $id)->first();
        $PostData['insurance_alias'] = $insurance['alias'];
        $PostData['status'] = 'Open';
        // dd($PostData['insurance_alias']);
        $insuranceEnquiry = Insurance_Enquiry::create($PostData);
        if($insuranceEnquiry){
            return response()->json([
                'status'  =>  true,
                'message' => 'Insurance enquiry submitted successfully',
            ]);
        } else {
            return response()->json([
                'status'  =>  false,
                'message' => 'Something went wrong! Please try again'
            ]);
        }

    }
}
