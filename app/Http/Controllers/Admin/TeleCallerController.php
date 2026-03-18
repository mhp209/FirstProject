<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Schema;


use App\Http\Controllers\Controller;
use App\Models\Emergency;
use App\Models\EmergencyHistories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Session;

use App\Models\Vehicle;
use App\Models\VehicleDocuments;
use App\Models\VehicleModel;

class TeleCallerController extends Controller
{

    public function AddEmergency()
    {
        $VehicleData = new Vehicle;
        return view('telecaller.add_search_emergency',compact('VehicleData'));
    }
    public function search(Request $request)
    {
        if($request->input('vehicle_no')){
            $rules =  [
                'vehicle_no' => 'required'
            ];
            $validatedData = $request->validate($rules);
        }

        $VehicleData = Vehicle::where('vehicle_no',$request->input('vehicle_no'))->first();
        if(!empty($VehicleData->vehicle_no)){
            return view('telecaller.add_search_emergency',compact('VehicleData'));
        }else{
            $VehicleData = new Vehicle;
            $error = "No Vehicle Found";
            return view('telecaller.add_search_emergency',compact('VehicleData','error'));
        }
    }
    /* Emergency Listing */
    public function EmergencyList(Request $request)
    {
        // if(Auth::guard('admin')->user()->role == 'TELECALLER'){
        //     $id = Auth::guard('admin')->user()->id;
        //     $EmergencyData = Emergency::where('telecaller_id', $id);
        // }elseif(Auth::guard('admin')->user()->role == 'SUPER_ADMIN' || Auth::guard('admin')->user()->role == 'ADMIN'){
        //     $EmergencyData = Emergency::query();
        // }
        // $EmergencyData = $EmergencyData->latest()->get();

        if ($request->ajax()) {

            $toDate ='';
            $fromDate ='';
            if($request->input('date_range') !=''){
                $dtRangeArr=explode(' to ', $request->input('date_range'));
                $fromDate=(isset($dtRangeArr[0]))?$dtRangeArr[0]:'';
                $toDate=(isset($dtRangeArr[1]))?$dtRangeArr[1]:'';
            }

            $wherestr = "emergencies.id !=''";
            if($fromDate!='' && $toDate ==''){
                $wherestr .= "AND DATE(emergencies.created_at) ='".$fromDate."' ";
            }
            else if($fromDate!='' && $toDate !='')
            {
                $wherestr .= "AND DATE(emergencies.created_at) >='".$fromDate."' ";
            }

            if($toDate!=''){
                $wherestr .= " AND DATE(emergencies.created_at) <='".$toDate."' ";
            }

            $userRole = Auth::guard('admin')->user()->role;
            if ($userRole == 'TELECALLER') {
                $id = Auth::guard('admin')->user()->id;
                $Data =  Emergency::with('adminRole')->whereRaw($wherestr)
                                ->orderBy('id', 'desc')
                                ->where('telecaller_id', $id)
                                ->get();
            }else{
                $Data =  Emergency::with('adminRole')->whereRaw($wherestr)
                                ->orderBy('id', 'desc')
                                ->get();
            }

            return DataTables($Data)
                ->addColumn('caller_name', function ($Data) {
                    return ucwords($Data->caller_name);
                })
                ->addColumn('created_at', function ($Data) {
                    return $Data->created_at;
                })
                ->addColumn('telecaller_name', function ($Data) {
                    return ucwords($Data->adminRole->name ?? "");
                })
                ->addColumn('emergency_call', function ($Data) {
                    // $emergency_call = '<a class="action_icon emergency_call" data-id="'.$Data->id.'"><i class="fa fa-phone"></i></a>';
                    $action_url = route('admin.emergency-history', $Data->id );
                    $emergency_call = '<a class="action_icon" href="'.$action_url.'" title="Edit"><i class="fa fa-pencil"></i></a>';
                    return $emergency_call;
                })
                ->addColumn('action', function ($Data) {
                    $action_line =  '<a class="action_icon view" data-id="'.$Data->id .'" title="View"><i class="fa fa-eye m-r-5"></i></a>';
                    if(Auth::guard('admin')->user()->role == 'TELECALLER'){
                        $edit_url = route('admin.edit-emergency', $Data->id );
                        $action_line .= '<a class="action_icon" href="'.$edit_url.'" title="Edit"><i class="fa fa-pencil m-r-5"></i></a>';
                        $action_line .= '<a data-bs-toggle="tooltip" data-id="'.$Data->id .'" class="action_icon ml-1 delete" title="Delete"><i class="fa fa-trash-o"></i></a>';
                    }
                    return $action_line;
                })
                ->rawColumns(['emergency_call','action'])
                ->make(true);

        }
        return view('telecaller.emergency');
    }

    public function storeEmergency(Request $request)
    {
        $rules =  [
            'caller_name' => 'required',
            'caller_number' => 'required',
            'description' => 'required',
            'vehicle_no' => 'required'
        ];
        $validatedData = $request->validate($rules);

        $PostData = $request->all();
        if(array_key_exists("id",$PostData)){
            $emergencyData = Emergency::find($PostData['id']);
            $emergencyData->update($request->all());
            session()->flash('success', 'EmergencyData successfully Updated.');
        }else{
            $emergencyData = Emergency::create($request->all());
            session()->flash('success', 'EmergencyData successfully Added.');
        }

        return response()->json(['redirect' => route('admin.emergency')]);

        // return redirect()->to('admin/enquiry');
    }

    public function EditEmergency(string $id){
        $EmergencyData = Emergency::find($id);
        $EmergencyHistories = EmergencyHistories::with('Emergency')->where('emergency_id',$EmergencyData->id)->orderBy('created_at','DESC')->get();
        // dd($EmergencyHistories);
        return view('telecaller.edit_emergency',compact('EmergencyData','EmergencyHistories'));
    }

    public function destroy(string $id)
    {
        $emergency = Emergency::where('id', $id)->delete();
        return $emergency;
    }

    public function view(string $id)
    {
        $Emergency = Emergency::where('id',$id)->first();
        $VehicleData = Vehicle::where('id',$Emergency->vehicle_id)->first();
        $EmergencyHistoriesData = EmergencyHistories::with('Emergency')->where('emergency_id',$Emergency->id)->get();
        $page = view('telecaller.view_emergency',compact('VehicleData','Emergency','EmergencyHistoriesData'))->render();
        return response()->json(['page' => $page]);
    }

    public function emergency_history(string $id)
    {
        $Emergency = Emergency::where('id',$id)->first();
        $EmergencyData = EmergencyHistories::with('Emergency')->where('emergency_id',$Emergency->id)->get();
        // $page = view('telecaller.call_emergency',compact('Emergency','EmergencyData'))->render();
        // return response()->json(['page' => $page]);
        return view('telecaller.call_emergency',compact('Emergency','EmergencyData'));
    }


    public function call_emergency(string $id)
    {
        $Emergency = Emergency::where('id',$id)->first();
        $EmergencyData = EmergencyHistories::with('Emergency')->where('emergency_id',$Emergency->id)->orderBy('created_at','DESC')->get();
        $page = view('telecaller.call_emergency',compact('Emergency','EmergencyData'))->render();
        return response()->json(['page' => $page]);
    }

    public function storeCallEmergency(Request $request)
    {
        $rules =  [
            'status' => 'required',
            'details' => 'required',
        ];
        $validatedData = $request->validate($rules);
        $PostData = $request->all();
        $Emergency = Emergency::where('id',$request->id)->first();
        $PostData['emergency_id'] = $Emergency->id;

        $emergencyData = EmergencyHistories::create($PostData);
        session()->flash('success', 'Emergency call successfully Added.');

        return redirect()->back();
    }

    public function updateStatus(Request $request)
    {
        $id = $request->input('id');
        $safety_option = EmergencyHistories::where('id', $id)->first();
        $safety_option->status  = $request->input('status');
        $safety_option->update();
        return $safety_option;
    }

}
