<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Promocode;
use Illuminate\Http\Request;

class PromocodeController extends Controller
{
    public function promocode(Request $request)
    {
        $price = $request->price;
        $quantity = $request->quantity;

        $promocode = Promocode::where(['status' => '1','assign_for'=>'web'])->get();

        $promocodeArray = GetPromoCode($quantity,$price);
        if(empty($promocodeArray)){
            return response()->json([
                'status' => false,
                'message' => 'Data not found',
            ]);
        }

        return response()->json([
            'status'  =>  true,
            'message' => 'Promocode fetch successfully',
            'data'    =>  $promocodeArray
        ]);
    }

    public function GetDiscount(Request $request)
    {
        $code = $request->code;
        $price = $request->price;
        $quantity =  $request->quantity;
        $discount =  GetDiscount($code,$quantity,$price);

        if($discount != 0){
            $data['discount'] = $discount;
        }else{
            $data['discount'] = '';
        }

        if($discount){
            return response()->json([
                'status'  =>  true,
                'message' => 'Promocode applied successfully',
                'data'    =>  $data
            ]);
        }else{
            return response()->json([
                'status'  =>  false,
                'message' => 'invalid Code',
            ]);
        }
    }
}
