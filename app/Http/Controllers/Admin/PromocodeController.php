<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Promocode;
use Illuminate\Http\Request;

class PromocodeController extends Controller
{
    public function index(Request $request)
    {
        $promocode_Obj =  new Promocode();
        $promocode =  Promocode::with('adminRole')->latest()->get();
        if (isset($request->uid) && $request->uid != '') {
            $promocode_Obj = Promocode::where('id', $request->uid)->first();
        }
        return view('admin.promocode.form',compact('promocode','promocode_Obj'));
    }

    public function store(Request $request)
    {
        $rules = [
            'assign_for' => 'required',
            'discount_type' => 'required',
            'minimum_type' => 'required',
            'minimum_value' => 'required',
            'description' => 'required',
        ];
        $PostData = $request->all();
        $PostData['assign_to'] = $request->assign_to ?? 0;
        $PostData['discount_per'] = $request->discount_per ?? 0;
        $PostData['discount_flat'] = $request->discount_flat ?? 0;
        $message = "";
        if ($request->id == '' || $request->id == null) {
            $rules['code'] = 'required|unique:promocodes';
            $this->validate($request,$rules);
            unset($PostData['id']);
            $promocode = Promocode::create($PostData);
            $message = "Promocode create successfully";
        } else {
            $rules['code'] = 'required|unique:promocodes,code,' . $request->id;
            $this->validate($request,$rules);
            $promocode = Promocode::where('id', $request->id)->first();
            $promocode = $promocode->update($PostData);
            $message = "Promocode update Successfully";
        }

        if ($promocode) {
            return redirect()->to('admin/promocode')
                ->with('success', $message);
        } else {
            return redirect()->to('admin/promocode')
                ->with('error', 'Something is wrong');
        }
    }

    public function assignPromocode(Request $request)
    {
        $role = $request->input('assign_for');

        if ($role == 'seller') {
            $admins = Admin::whereIn('role', ['SELL_EMPLOYEE'])
                ->where('status', 1)
                ->get();
        } elseif ($role == 'franchise') {
            $admins = Admin::whereIn('role', ['FRANCHISE_PARTNER'])
                ->where('status', 1)
                ->get();
        } else {
            $admins = [];
        }

        return response()->json(['admins' => $admins]);
    }

    public function destroy($id)
    {
        $promocode = Promocode::find($id);
        $promocode->delete();
        return redirect()->back()->with('success', 'Promocode deleted successfully');
    }

    public function updateStatus(Request $request)
    {
        $id = $request->input('id');
        $promocode = Promocode::where('id', $id)->first();
        $promocode->status = $request->input('status');
        $promocode->update();
        return $promocode;
    }
}
