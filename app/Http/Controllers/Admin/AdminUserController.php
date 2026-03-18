<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Schema;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\Admin;
use App\Models\User;
use function DataTables;
class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

            $wherestr = "admins.id !=''";
            if($fromDate!='' && $toDate ==''){
                $wherestr .= "AND DATE(admins.created_at) ='".$fromDate."' ";
            }
            else if($fromDate!='' && $toDate !='')
            {
                $wherestr .= "AND DATE(admins.created_at) >='".$fromDate."' ";
            }

            if($toDate!=''){
                $wherestr .= " AND DATE(admins.created_at) <='".$toDate."' ";
            }

            // $UserData = $UserData->get();
            $Data =  Admin::whereRaw($wherestr)
                                ->where('id', '!=', 1)
                                ->orderBy('id', 'desc')
                                ->get();

            return DataTables($Data)
                ->addColumn('name', function ($Data) {
                    return ucwords($Data->name);
                })
                ->addColumn('created_at', function ($Data) {
                    return $Data->created_at;
                })
                ->addColumn('status', function ($Data) {
                    $status = $Data->status == '0' ? '<i class="fa fa-dot-circle-o text-danger"></i> Inactive' : '<i class="fa fa-dot-circle-o text-success"></i> Active';
                    $toggleValue = $Data->status == '0' ? '1' : '0';

                    $status_line =  '<div class="dropdown action-label">';
                        $status_line .= '<a class="btn btn-white btn-sm btn-rounded dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton" href="javascript:;" aria-expanded="false" data-id="'.$Data->id.'" value="'.$toggleValue.'">'.$status.'</a>';

                        $status_line .= '<div class="dropdown-menu dropdown-menu-right">';
                        $status_line .= '<a class="dropdown-item status" href="javascript:;" data-id="'.$Data->id.'" value="1"><i class="fa fa-dot-circle-o text-success"></i> Active</a>';
                        $status_line .= '<a class="dropdown-item status" href="javascript:;" data-id="'.$Data->id.'" value="0"><i class="fa fa-dot-circle-o text-danger"></i> Inactive</a>';
                    $status_line .= '</div></div>';
                    return $status_line;
                })
                ->addColumn('action', function ($Data) {
                    $edit_url = route("users.edit", $Data->id);
                    $del_url = url('admin/user-del/' . $Data->id);

                    $action_line =  '<a class="action_icon" href="'.$edit_url.'" title="Edit"><i class="fa fa-pencil"></i></a>';

                    $action_line .=  '<a href="javascript:;" data-bs-toggle="tooltip" data-id="'.$Data->id.'" data-href="'.$del_url.'" ';
                    $action_line .=  'class="action_icon ml-1 delete" title="Delete"><i class="fa fa-trash-o"></i></a>';
                    return $action_line;
                })
                ->rawColumns(['status','action'])
                ->make(true);

        }
        return view('admin.users.index');

        // <td colspan="2">
        //     <a class="action_icon" href="{{ route('users.edit', $data->id) }}" title="Edit"><i class="fa fa-pencil"></i></a>
        //     <a href="javascript:;" data-bs-toggle="tooltip" data-id="'.$data->id.'"
        //         data-href="{{ url('admin/user-del/' . $data->id) }}"
        //         class="action_icon ml-1 delete" title="Delete"><i
        //         class="action_icon ml-1 delete" title="Delete"><i
        //             class="fa fa-trash-o"></i></a>
        // </td>
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $adminObj =  new Admin();
        $form_type = 'add';
        return view('admin.users.create', compact('adminObj','form_type'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules =  [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:admins',
            'password' => 'required|min:8',
            'mobile_number' => 'required',
            'whats_no' => 'required',
        ];

        $validatedData = $request->validate($rules);

        $admin = new Admin();
        $name = $request->first_name .' '. $request->last_name;
        $admin->name  = $name;
        $admin->first_name  = $request->first_name;
        $admin->last_name  = $request->last_name;
        $admin->email  = $request->email;
        $admin->password  = Hash::make($request->password);
        $admin->mobile_number  = $request->mobile_number;
        $admin->whats_no  = $request->whats_no;
        $admin->role  = $request->role;
        $store = $admin->save();
        if($store){
            return redirect()->to('admin/users')->with('success', "Data Save Successfully");
        }else{
            return redirect()->to('admin/users')->with('error','Something is wrong');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $adminObj = Admin::where('id', $id)->first();
        $form_type = 'update';
        return view('admin.users.edit', compact('adminObj','form_type'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $rules =  [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'mobile_number' => 'required',
            'whats_no' => 'required',
            'role' => 'required',
        ];
        if(!empty($request->password)){
            $rules['password'] = 'required|min:8';
        }

        $this->validate($request,$rules);
        $admin = Admin::where('id', $id)->first();
        $name = $request->first_name .' '. $request->last_name;
        $admin->name  = $name;
        $admin->first_name  = $request->first_name;
        $admin->last_name  = $request->last_name;
        $admin->email  = $request->email;
        $admin->mobile_number  = $request->mobile_number;
        $admin->whats_no  = $request->whats_no;
        $admin->role  = $request->role;
        if(!empty($request->password)){
            $admin->password  = Hash::make($request->password);
        }
        $store = $admin->update();
        if($store){
            return redirect()->to('admin/users')->with('success', "Data Update Successfully");
        }else{
            return redirect()->to('admin/users')->with('error','Something is wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $admin = Admin::where('id', $id)->delete();
        return $admin;
    }

    public function updateAdminStatus(Request $request)
    {
        $admin = Admin::where('id', $request->input('id'))->first();
        $admin->status  = $request->input('status');
        $admin->update();
        return $admin;
    }

    public function FrontUsers(Request $request)
    {
        // $UserData = User::query()->where('status','1');

        // $filter = $request->input('filter');
        // if ($filter) {
        //     $columns = Schema::getColumnListing('users');
        //     $UserData->where(function ($query) use ($filter, $columns) {
        //     $columns = Schema::getColumnListing('users');
        //         foreach ($columns as $column) {
        //             $query->orWhere($column, 'like', "%$filter%");
        //         }
        //     });
        // }
        // $UserData = $UserData->latest()->paginate(10);
        // $UserData->appends(['filter' => $filter]);
        // return view('admin.frontusers', compact('UserData','filter'));

        if ($request->ajax()) {

            $toDate ='';
            $fromDate ='';
            if($request->input('date_range') !=''){
                $dtRangeArr=explode(' to ', $request->input('date_range'));
                $fromDate=(isset($dtRangeArr[0]))?$dtRangeArr[0]:'';
                $toDate=(isset($dtRangeArr[1]))?$dtRangeArr[1]:'';
            }

            $wherestr = "users.id !=''";
            if($fromDate!='' && $toDate ==''){
                $wherestr .= "AND DATE(users.created_at) ='".$fromDate."' ";
            }
            else if($fromDate!='' && $toDate !='')
            {
                $wherestr .= "AND DATE(users.created_at) >='".$fromDate."' ";
            }

            if($toDate!=''){
                $wherestr .= " AND DATE(users.created_at) <='".$toDate."' ";
            }

            // $UserData = $UserData->get();
            $UserData =  User::whereRaw($wherestr)
                                ->orderBy('created_at','desc')
                                ->get();

            return DataTables($UserData)
                ->addColumn('name', function ($UserData) {
                    return ucwords($UserData->name);
                })
                ->addColumn('created_at', function ($UserData) {
                    return $UserData->created_at;
                })
                ->make(true);
        }
        return view('admin.frontusers');
    }

}
