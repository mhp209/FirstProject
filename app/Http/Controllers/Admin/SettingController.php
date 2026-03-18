<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(Request $request)
    {       
        $Setting = setting::first();
        if(!$Setting){
            $Setting = new setting();
        }
        return view('admin.setting', compact('Setting'));
    }

    public function store(Request $request)
    {        
        $postData = $request->all();
        $message = "";
        if ($request->id == '' || $request->id == null) {
            unset($postData['id']);
            $store = setting::create($postData);
            $message = "Data Add Successfully";
        } else {           
            $discount = setting::find($request->id);     
            $store = $discount->update($postData);
            $message = "Data update Successfully";
        }

        if ($store) {
            return redirect()->to('admin/setting')
                ->with('success', $message);
        } else {
            return redirect()->to('admin/setting')
                ->with('error', 'Something is wrong');
        }
    }
}
