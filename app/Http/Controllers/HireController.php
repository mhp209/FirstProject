<?php

namespace App\Http\Controllers;

use App\Models\HireEnquiry;
use Illuminate\Http\Request;

class HireController extends Controller
{
    /* Front - Cab and bus Store */
    public function hireCab()
    {
        return view('front.hire_cab');
    }

    public function hireBus()
    {
        return view('front.hire_bus');
    }

    public function hireStore(Request $request, $hireType)
    {
        $rules =  [
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile_number' => 'required',
            'email' => 'required',
            'trip_type' => 'required',
            'type_vehicle' => 'required',
            'pickup_city' => 'required',
            'dest_city' => 'required',
        ];
        $validatedData = $request->validate($rules);

        $PostData = $request->all();
        $PostData['status'] = 'Open';

        if ($hireType === 'cab') {
            $PostData['hire_name'] = 'hire_cab';
        } elseif ($hireType === 'bus') {
            $PostData['hire_name'] = 'hire_bus';
        }

        $hire_Enquiry = HireEnquiry::create($PostData);
        if ($hire_Enquiry) {
            session()->flash('success', 'Your Enquiry is added. Respective Person contact you.');
        }

        if ($hireType === 'cab') {
            return redirect()->route('hire.cab');
        } elseif ($hireType === 'bus') {
            return redirect()->route('hire.bus');
        }
    }

    /* Admin - Cab and Bus listing */
    public function cabEnquiry(Request $request)
    {
        if ($request->ajax()) {

            $toDate ='';
            $fromDate ='';
            if($request->input('date_range') !=''){
                $dtRangeArr=explode(' to ', $request->input('date_range'));
                $fromDate=(isset($dtRangeArr[0]))?$dtRangeArr[0]:'';
                $toDate=(isset($dtRangeArr[1]))?$dtRangeArr[1]:'';
            }

            $wherestr = "hire_enquiries.id !=''";
            if($fromDate!='' && $toDate ==''){
                $wherestr .= "AND DATE(hire_enquiries.created_at) ='".$fromDate."' ";
            }
            else if($fromDate!='' && $toDate !='')
            {
                $wherestr .= "AND DATE(hire_enquiries.created_at) >='".$fromDate."' ";
            }

            if($toDate!=''){
                $wherestr .= " AND DATE(hire_enquiries.created_at) <='".$toDate."' ";
            }

            $Data =  HireEnquiry::whereRaw($wherestr)
                                ->where('hire_name','hire_cab')
                                ->orderBy('id', 'desc')
                                ->get();

            return DataTables($Data)
                ->addColumn('name', function ($Data) {
                    return ucfirst($Data->first_name).' '.ucfirst($Data->last_name);
                })
                ->addColumn('trip_type', function ($Data) {
                    return $Data->trip_type;
                })
                ->addColumn('type_vehicle', function ($Data) {
                    return $Data->type_vehicle;
                })
                ->addColumn('pickup_city', function ($Data) {
                    return $Data->pickup_city;
                })
                ->addColumn('dest_city', function ($Data) {
                    return $Data->dest_city;
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
                ->rawColumns(['status','action'])
                ->make(true);
        }
        return view('admin.hireEnquiry.cabEnquiry');
    }

    public function busEnquiry(Request $request)
    {
        if ($request->ajax()) {

            $toDate ='';
            $fromDate ='';
            if($request->input('date_range') !=''){
                $dtRangeArr=explode(' to ', $request->input('date_range'));
                $fromDate=(isset($dtRangeArr[0]))?$dtRangeArr[0]:'';
                $toDate=(isset($dtRangeArr[1]))?$dtRangeArr[1]:'';
            }

            $wherestr = "hire_enquiries.id !=''";
            if($fromDate!='' && $toDate ==''){
                $wherestr .= "AND DATE(hire_enquiries.created_at) ='".$fromDate."' ";
            }
            else if($fromDate!='' && $toDate !='')
            {
                $wherestr .= "AND DATE(hire_enquiries.created_at) >='".$fromDate."' ";
            }

            if($toDate!=''){
                $wherestr .= " AND DATE(hire_enquiries.created_at) <='".$toDate."' ";
            }

            $Data =  HireEnquiry::whereRaw($wherestr)
                                ->where('hire_name','hire_bus')
                                ->orderBy('id', 'desc')
                                ->get();

            return DataTables($Data)
                ->addColumn('name', function ($Data) {
                    return ucfirst($Data->first_name).' '.ucfirst($Data->last_name);
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
                ->rawColumns(['status','action'])
                ->make(true);
        }
        return view('admin.hireEnquiry.busEnquiry');
    }

    public function updateStatus(Request $request)
    {
        $id = $request->input('id');
        $Hire_enquiry = HireEnquiry::where('id', $id)->first();
        $Hire_enquiry->status  = $request->input('status');
        $Hire_enquiry->update();
        return $Hire_enquiry;
    }

    public function viewHireEnquiry(string $id)
    {
        $Enquiry = HireEnquiry::where('id',$id)->first();
        $page = view('admin.hireEnquiry.viewEnquiry',compact('Enquiry'))->render();
        return response()->json(['page' => $page]);
    }
}
