<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SafetyOption;

class SafetyOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $safety_optionObj = new SafetyOption();
        $safety_option = SafetyOption::latest()->get();
        if(isset($request->sid) && $request->sid != '')
        {

            $safety_optionObj = SafetyOption::where('id',$request->sid)->first();
        }
        $i=1;
        return view('admin.safetyoption.index', compact('safety_option','safety_optionObj','i') );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $message = "";
        if($request->sid == '' || $request->sid == null)
        {

            $this->validate($request, [
                'reason_option' => 'required|unique:safety_options',
                'alias' => 'required|unique:safety_options'
            ]);

            $safety_option = new SafetyOption();
            $safety_option->reason_option  = $request->reason_option;
            $safety_option->alias  = $request->alias;
            $safety_option->message  = $request->message;
            $store = $safety_option->save();
            $message = "Data Add Successfully";
        } else {
            $this->validate($request, [
                'reason_option' => 'required',
                'alias' => 'required'
            ]);

            $safety_option = SafetyOption::where('id',$request->sid)->first();
            $safety_option->reason_option  = $request->reason_option;
            $safety_option->alias  = $request->alias;
            $safety_option->message  = $request->message;
            $store = $safety_option->update();
            $message = "Data update Successfully";
        }

        if($store){
            return redirect()->to('admin/safety-option')
            ->with('success',$message);
            }
        else
        {
            return redirect()->to('admin/safety-option')
            ->with('error','Something is wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $safety_option = SafetyOption::where('id', $id)->delete();
        return $safety_option;
    }

    public function updateSafetyStatus(Request $request)
    {
        $id = $request->input('id');
        $safety_option = SafetyOption::where('id', $id)->first();
        $safety_option->status  = $request->input('status');
        $safety_option->update();
        return $safety_option;
    }

    public function view(string $id)
    {
        $SafetyOption = SafetyOption::where('id',$id)->first();
        $page = view('admin.safetyoption.view',compact('SafetyOption'))->render();
        return response()->json(['page' => $page]);
    }
}
