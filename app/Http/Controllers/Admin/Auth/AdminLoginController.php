<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\Enquiry;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\barcode;
use App\Models\Admin;
use App\Models\Emergency;
use App\Models\Insurance;
use App\Models\Insurance_Enquiry;
use App\Models\order;
use App\Models\SmsAlert;

class AdminLoginController extends Controller
{
    use AuthenticatesUsers;

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function showAdminLoginForm(Request $request)
    {
        if (Auth::guard('admin')->check()) {
			return redirect(route('admin.dashboard'));
		}
        return view('admin.auth.login');
    }

    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:8'
        ]);

        if (Auth::guard('admin')->attempt($request->only(['email', 'password']), $request->get('remember'))) {

            if(Auth::guard('admin')->user()->status == 0){
                session()->forget('admin_session');
                Auth::guard('admin')->logout();
                return redirect()->route('admin')->with('error','This user is not active');
            }

            return redirect()->route('admin.dashboard');
        }

        return back()->withInput($request->only('email', 'remember'))->with('error','Admin Not Found');
    }

    public function dashboard()
    {
        if(Auth::guard('admin')->user()->role == 'SUPER_ADMIN' || Auth::guard('admin')->user()->role == 'ADMIN'){

            $pageData['total_user'] = User::count();
            $pageData['total_enquiry'] = Emergency::count();
            $pageData['total_barcode'] = Barcode::where('status','1')->count();
            $pageData['total_seller'] = Admin::where('role','SELL_EMPLOYEE')->count();

            $pageData['total_revenue'] = order::where('status','COMPLETED')->sum('total_amount');
            $pageData['web_barcode'] = Barcode::where('type','web')->count();
            $pageData['seller_barcode'] = Barcode::where('type','seller')->count();
            $pageData['franchise_barcode'] = Barcode::where('type','franchise')->count();

            $pageData['recent_order'] = order::latest()->take(5)->get();
            $pageData['recent_user'] = User::latest()->take(5)->get();
            $pageData['recent_emegrency'] = Emergency::with('adminRole')->latest()->take(5)->get();
            $pageData['recent_vehicle'] = Vehicle::with('VehicleBrand','VehicleModel')->latest()->take(5)->get();
            $pageData['recent_alert'] = SmsAlert::latest()->take(5)->get();
            $pageData['recent_insurance'] = Insurance_Enquiry::with('adminRole','Insurance')->latest()->take(5)->get();

            // pre($pageData);exit;
            return view('admin.dashboard',compact('pageData'));

        }elseif(Auth::guard('admin')->user()->role == 'TELECALLER'){
            $id = Auth::guard('admin')->user()->id;
            $total_enquiry = Emergency::where('telecaller_id', $id)->count();
            return view('telecaller.dashboard',compact('total_enquiry'));
        }elseif(Auth::guard('admin')->user()->role == 'SELL_EMPLOYEE'){
            $user_id = Auth::guard('admin')->user()->id;
            $total_barcode = barcode::where('type','seller')->where('assign_to',$user_id)->count();
            $active_barcode = barcode::where('type','seller')->where('assign_to',$user_id)->where('status',1)->count();
            return view('seller.dashboard',compact('total_barcode','active_barcode'));
        }elseif(Auth::guard('admin')->user()->role == 'FRANCHISE_PARTNER'){
            $user_id = Auth::guard('admin')->user()->id;
            $total_barcode = barcode::where('type','franchise')->where('assign_to',$user_id)->count();
            $active_barcode = barcode::where('type','franchise')->where('customer_id', '!=', 0)->count();
            return view('franchise.dashboard',compact('total_barcode','active_barcode'));
        }
    }

    public function logout()
    {
        session()->forget('admin_session');
        Auth::guard('admin')->logout();
        return redirect()->route('admin');
    }

}
