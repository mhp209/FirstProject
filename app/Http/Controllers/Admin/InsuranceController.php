<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Schema;

use App\Http\Controllers\Controller;
use App\Models\HireEnquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\Insurance_Enquiry;
use App\Models\Insurance;

class InsuranceController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $toDate ='';
            $fromDate ='';
            if($request->input('date_range') !=''){
                $dtRangeArr=explode(' to ', $request->input('date_range'));
                $fromDate=(isset($dtRangeArr[0]))?$dtRangeArr[0]:'';
                $toDate=(isset($dtRangeArr[1]))?$dtRangeArr[1]:'';
            }

            $wherestr = "insurance__enquiries.id !=''";
            if($fromDate!='' && $toDate ==''){
                $wherestr .= "AND DATE(insurance__enquiries.created_at) ='".$fromDate."' ";
            }
            else if($fromDate!='' && $toDate !='')
            {
                $wherestr .= "AND DATE(insurance__enquiries.created_at) >='".$fromDate."' ";
            }

            if($toDate!=''){
                $wherestr .= " AND DATE(insurance__enquiries.created_at) <='".$toDate."' ";
            }

            $userRole = Auth::guard('admin')->user()->role;
            if ($userRole == 'TELECALLER' || $userRole == 'SELL_EMPLOYEE' || $userRole == 'FRANCHISE_PARTNER') {
                $id = Auth::guard('admin')->user()->id;
                $Data =  Insurance_Enquiry::with('adminRole','Insurance')->whereRaw($wherestr)
                                ->orderBy('id', 'desc')
                                ->where('generated_by', $id)
                                ->get();
            }else{
                $Data =  Insurance_Enquiry::with('adminRole','Insurance')->whereRaw($wherestr)
                                ->orderBy('id', 'desc')
                                ->get();
            }

            return DataTables($Data)
                ->addColumn('insurance_alias', function ($Data) {
                    return ucwords($Data->Insurance->name ?? "");
                })
                ->addColumn('name', function ($Data) {
                    return ucfirst($Data->first_name).' '.ucfirst($Data->last_name);
                })
                ->addColumn('lead_from', function ($Data) {
                    return ucfirst($Data->adminRole->name ?? "");
                })
                ->addColumn('created_at', function ($Data) {
                    return $Data->created_at;
                })
                ->addColumn('status', function ($Data) {
                    $status = $Data->status == 'Close' ? '<i class="fa fa-dot-circle-o text-danger"></i> Close' : '<i class="fa fa-dot-circle-o text-success"></i> Open';
                    $toggleValue = $Data->status == 'Close' ? 'Open' : 'Close';

                    $status_line =  '<div class="dropdown action-label">';
                        $status_line .= '<a class="btn btn-white btn-sm btn-rounded dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton" href="javascript:;" aria-expanded="false" data-id="'.$Data->id.'" value="'.$toggleValue.'">'.$status.'</a>';

                        $status_line .= '<div class="dropdown-menu dropdown-menu-right">';
                        $status_line .= '<a class="dropdown-item status" href="javascript:;" data-id="'.$Data->id.'" value="Open"><i class="fa fa-dot-circle-o text-success"></i> Open</a>';
                        $status_line .= '<a class="dropdown-item status" href="javascript:;" data-id="'.$Data->id.'" value="Close"><i class="fa fa-dot-circle-o text-danger"></i> Close</a>';
                    $status_line .= '</div></div>';
                    return $status_line;
                })
                ->addColumn('action', function ($Data) {
                    $action_line =  '<a class="action_icon view" data-id="'.$Data->id.'" title="View"><i class="fa fa-eye"></i></a>';
                    return $action_line;
                })
                ->rawColumns(['status','action','lead_from'])
                ->make(true);
        }
        return view('admin.insurance.list');
    }

    public function updateInseEquiryStatus(Request $request)
    {
        $id = $request->input('id');
        $safety_option = Insurance_Enquiry::where('id', $id)->first();
        $safety_option->status  = $request->input('status');
        $safety_option->update();
        return $safety_option;
    }

    public function view(string $id)
    {
        $Enquiry = Insurance_Enquiry::with('Insurance')->where('id',$id)->first();
        $page = view('admin.insurance.view_enquiry',compact('Enquiry'))->render();
        return response()->json(['page' => $page]);
    }

    public function Insurance(Request $request)
    {
        $insurance_Obj =  new Insurance();
        $insurance =  Insurance::latest()->get();
        if (isset($request->uid) && $request->uid != '') {
            $insurance_Obj = Insurance::where('id', $request->uid)->first();
        }
        return view('admin.insurance.index', compact('insurance', 'insurance_Obj'));
    }

    public function store(Request $request)
    {
        $message = "";
        if ($request->uid == '' || $request->uid == null) {
            $this->validate($request, [
                'name' => 'required|string',
                'alias' => 'required|string',
                'image' => 'required|max:2048'
            ]);

            $insurance =  new Insurance();
            $insurance->name  = $request->name;
            $insurance->alias  = $request->alias;
            $insurance->order_by  = $request->order_by;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $destinationPath = public_path('uploads/InsuranceImage');
                $profileImage = date('YmdHis') . '.' . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $insurance->image =   $profileImage;
            }
            $store = $insurance->save();
            $message = "Data Add Successfully";
        } else {

            $this->validate($request, [
                'name' => 'required|string',
                'alias' => 'required|string',
                'image' => 'required|max:2048'
            ]);
            $insurance = Insurance::where('id', $request->uid)->first();
            // dd($insurance);
            $insurance->name  = $request->name;
            $insurance->alias  = $request->alias;
            $insurance->order_by  = $request->order_by;
            if ($request->hasFile('image')) {
                if(file_exists(public_path('/uploads/InsuranceImage/'.$insurance->image)))
                {
                    unlink(public_path('/uploads/InsuranceImage/'.$insurance->image));
                }
                $image = $request->file('image');
                $destinationPath = public_path('uploads/insuranceImage');
                $profileImage = date('YmdHis') . '.' . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $insurance->image = $profileImage;
            }

            $store = $insurance->update();
            $message = "Data update Successfully";
        }

        if ($store) {
            return redirect()->to('admin/insurance')
                ->with('success', $message);
        } else {
            return redirect()->to('admin/insurance')
                ->with('error', 'Something is wrong');
        }
    }

    public function destroy($id)
    {
        $insurance = Insurance::find($id);
        if(file_exists(public_path('/uploads/InsuranceImage/'.$insurance->image)))
        {
            unlink(public_path('/uploads/InsuranceImage/'.$insurance->image));
        }
        $insurance->delete();
        return redirect()->back()->with('success', 'Insurance deleted successfully');
    }

    public function updateinsuranceStatus(Request $request)
    {
        $id = $request->input('id');
        $insurance = Insurance::where('id', $id)->first();
        $insurance->status = $request->input('status');
        $insurance->update();
        return $insurance;
    }

    public function addInsurance()
    {
        $ins_alias = Insurance::get();
        return view('admin.insurance.create_insurance',compact('ins_alias'));
    }

    public function storeInsurance(Request $request)
    {
        $postData = $request->all();
        $postData['generated_by'] = Auth::guard('admin')->user()->id;
        $postData['status'] = 'Open';
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $destinationPath = public_path('uploads/insurance');
            $profileImage = date('YmdHis') . '.' . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $postData['image'] =   $profileImage;
        }
        // pre($postData);exit;
        $Insurance_Enquiry = Insurance_Enquiry::create($postData);
        if($Insurance_Enquiry){
            session()->flash('success', 'Your Enquiry is added');
        }
        return redirect()->route('admin.ins_enquiry');
    }

}
