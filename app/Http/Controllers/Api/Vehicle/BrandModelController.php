<?php

namespace App\Http\Controllers\Api\Vehicle;

use App\Http\Controllers\Controller;
use App\Models\VehicleBrand;
use App\Models\VehicleModel;
use Illuminate\Http\Request;
use Validator;

use function PHPUnit\Framework\isEmpty;

class BrandModelController extends Controller
{
    public function brand(Request $request)
    {
        $brand = VehicleBrand::get();
        if ($brand) {
            foreach ($brand as $item) {
                $data['id'] = $item->id ?? '';
                $data['name'] = $item->name ?? '';
                $brandArray[] = $data;
            }
        }
        return response()->json([
            'status' => true,
            'message' => 'Vehicle brand fetch successfully',
            'data' => $brandArray,
        ]);
    }

    public function model(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brand_id' => 'required',
        ]);
        $vehiclemodel =  $request->input('brand_id');

        if ($validator->fails()) {
            return $response = [
                'status' => false,
                'message' => $validator->errors()->first()
            ];
        }

        $model = VehicleModel::with('brand')->where(['brand_id' => $request->brand_id])->get();
        // $modelArray = [];
        if(!$model->isEmpty()) {
            foreach ($model as $item) {
                $data['id'] = $item->id ?? '';
                $data['name'] = $item->name ?? '';
                $modelArray[] = $data;
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data not found',
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => 'Vehicle model fetch successfully',
            'data' => $modelArray,
        ]);
    }

    public function vehicleType(Request $request)
    {
        $vehicletype = vehicleTypes();

        return response()->json([
            'status' => true,
            'message' => 'Vehicle type fetch successfully',
            'data' => $vehicletype,
        ]);
    }
}
