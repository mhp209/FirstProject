<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmation;
use App\Models\ContactUs;
use App\Models\Discount;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
// use Mail;

use App\Models\Vehicle;
use App\Models\order;
use App\Models\Promocode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        session()->flash('module', 'home');
        return view('front.home');
    }
    public function MyProfile()
    {
        session()->flash('module', 'profile');
        $user = new User();
        $customer_data = $user->where('id', Auth::user()->id)->first();

        $user_id =  Auth::user()->id;
        $Vehicle = new Vehicle();
        $vehicle_list = $Vehicle->where('user_id', $user_id)->with(['VehicleBrand', 'VehicleModel'])->orderBy('id', 'DESC')->get();

        $order_list = [];
        $order_list = order::where('user_id', $user_id)->orderBy('created_at', 'desc')->get();
        return view('front.my_account', compact('customer_data', 'vehicle_list', 'order_list'));
    }
    // public function edit(string $id)
    // {
    //     return view('user.edit');
    // }

    public function EditProfile()
    {
        session()->flash('module', 'profile');
        $user = new User();
        $customer_data = $user->where('id', Auth::user()->id)->first();
        return view('front.edit-profile', compact('customer_data'));
    }
    /* Profile Update */
    public function update(Request $request)
    {
        $this->middleware('auth');
        $user = new User();
        $id = $request->input('id');
        $Current_user = $user::where('id', $id)->first();
        $request->name = $request->input('first_name') . ' ' . $request->input('last_name');
        $store = $Current_user->update($request->all());
        if ($store) {
            $auth_user = auth()->user();
            $auth_user->name = $request->input('first_name') . ' ' . $request->input('last_name');
            $auth_user->first_name = $request->input('first_name');
            $auth_user->last_name = $request->input('last_name');
            $auth_user->email = strtolower($request->input('email'));
            $auth_user->blood_group = $request->input('blood_group');
            $auth_user->save();
            // dd($auth_user);
            return redirect()->to('my_account')->with('success', "Profile Updated Successfully");
        } else {
            return redirect()->to('my_account')->with('error', 'Something is wrong');
        }
    }

    public function about()
    {
        session()->flash('module', 'about');
        return view('front.about');
    }

    public function contact()
    {
        session()->flash('module', 'contact');
        return view('front.contact');
    }
    /* Contact Us */
    public function contactUs(Request $request)
    {
        $rules =  [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'mobile_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'message' => 'required'
        ];

        $contactData = $request->validate($rules);

        $contact = ContactUs::create($contactData);
        Mail::send('front.contact_mail', array(
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'email' => $request->get('email'),
            'mobile_number' => $request->get('mobile_number'),
            'messages' => $request->message,
        ), function ($message) use ($contact) {
            $message->to($contact->email)->subject('Contact Mail');
        });

        if ($contact) {
            return redirect()->back()->with('success', 'Thank you for contact us. we will contact you shortly.');
        }
    }
    /* Safety Page */
    public function product()
    {
        session()->flash('module', 'product ');
        $discount = Discount::first();
        $promocode = Promocode::where('assign_for','web')->get();
        return view('front.rs_safety_tag', compact('discount','promocode'));
    }
    /* All Data Truncate */
    public function truncate()
    {
        $ignore = ['failed_jobs', 'migrations', 'settings', 'admins', 'banners', 'insurances', 'roles', 'safety_options', 'states', 'vehicle_brands', 'vehicle_models'];
        $tables = Schema::getConnection()->getDoctrineSchemaManager()->listTableNames();

        $tablesToTruncate = array_diff($tables, $ignore);

        DB::beginTransaction();
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');

            foreach ($tablesToTruncate as $table) {
                DB::table($table)->truncate();
            }
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
            DB::commit();
            echo "All tables truncated successfully";
        } catch (\Exception $e) {
            DB::rollBack();
            echo "Error occurred while truncating tables: " . $e->getMessage();
        }
    }
    /* Testing Register Mail */
    public function test_mail()
    {    $first_name = $last_name = 'test';
        // return view('mail.register_mail',compact('first_name','last_name'));

        try {
            $user_data = [];
            $res = Mail::send('mail.register_mail', array(
                'first_name' => 'rutu',
                'last_name' => 'Sathwara',
            ), function ($message) use ($user_data) {
                $message->to('rutikasathwara.eww@gmail.com')->subject('Registration Confirmation');
            });
            // pre($res);
        } catch (\Exception $e) {
            logger()->error('Error sending email: ' . $e->getMessage());
            // pre("Email is not sent ") . $e->getMessage();
        }
        // dd('helo');
    }
    /* Tesing Order Mail */
    public function test_order()
    {
        $order = order::where('id',71)->first();
        // return view('mail.order_mail',compact('order'));
        // exit;
        try {

            Mail::to($order->email)->send(new OrderConfirmation($order));
        } catch (\Exception $e) {
            logger()->error('Error sending email: ' . $e->getMessage());
            // pre("Email is not sent ") . $e->getMessage();
        }
        // dd('helo');
    }
}
