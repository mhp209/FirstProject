<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class UserDashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    //     $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }
    public function MyAccount()
    {
        return view('home');
    }
    public function dashboard()
    {
        $customer_id = Auth::user()->id;
        $user = new User();
        $data['customer_data'] = $user->where('id', $customer_id)->first();
        // dd($data);
        return view('user.dashboard', compact('data'));
    }
}
