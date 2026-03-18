<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $role_Obj =  new Role();
        $roles =  Role::latest()->get();
        if(isset($request->uid) && $request->uid != '')
        {

            $role_Obj = Role::where('id',$request->uid)->first();
        }

        $i=1;
        return view('admin.roles.index', compact('roles','role_Obj','i'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $message = "";
        if($request->uid == '' || $request->uid == null)
        {
            $this->validate($request, [
                'name' => 'required|unique:roles',
                'alias' => 'required|unique:roles'
            ]);

            $role =  new Role();
            $role->name  = $request->name;
            $role->alias  = $request->alias;
            $store = $role->save();
            $message = "Data Add Successfully";
        } else {
            $this->validate($request, [
                'name' => 'required',
                'alias' => 'required'
            ]);

            $role = Role::where('id',$request->uid)->first();
            $role->name  = $request->name;
            $role->alias  = $request->alias;
            $store = $role->update();
            $message = "Data update Successfully";
        }

        if($store){
            return redirect()->to('admin/roles')
            ->with('success',$message);
            }
        else
        {
            return redirect()->to('admin/roles')
            ->with('error','Something is wrong');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        $role->delete();
        return response()->json(['message' => 'Role  deleted successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function updateRoleStatus(Request $request)
    {
        $id = $request->input('id');
        $role = Role::where('id', $id)->first();
        $role->status  = $request->input('status');
        $role->update();
        return $role;
    }
}
