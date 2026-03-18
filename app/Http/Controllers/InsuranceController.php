<?php

namespace App\Http\Controllers;

use App\Models\HireEnquiry;
use Illuminate\Http\Request;

use App\Models\Insurance_Enquiry;
use App\Models\Insurance;
use Auth;

class InsuranceController extends Controller
{
    public function index()
    {
        session()->flash('module', 'store');
        return view('front.store');
    }
    /* front - insurance Page */
    public function Insurance(Request $request)
    {
        session()->flash('module', 'store');
        $insurances = Insurance::orderBy('order_by', 'desc')->get();
        return view('front.insurance.insurance', compact('insurances'));
    }
    /* Insurance Details Page */
    public function insuranceDetails(Request $request, $alias)
    {
        $insurances = Insurance::orderBy('order_by', 'desc')->get();
        if ($request->alias == 'car-insurance') {
            return view('front.insurance.car_details', compact('insurances'));
        } else if ($request->alias == 'bike-insurance') {
            return view('front.insurance.bike_details', compact('insurances'));
        } else if ($request->alias == 'medical-insurance') {
            return view('front.insurance.medical_details', compact('insurances'));
        } else if ($request->alias == 'travel-insurance') {
            return view('front.insurance.travel_details', compact('insurances'));
        } else if ($request->alias == 'fire-insurance') {
            return view('front.insurance.fire_details', compact('insurances'));
        } else if ($request->alias == 'life-insurance') {
            return view('front.insurance.life_details', compact('insurances'));
        } else if ($request->alias == 'term-insurance') {
            return view('front.insurance.term_ins_details', compact('insurances'));
        } else if ($request->alias == 'home-insurance') {
            return view('front.insurance.home_details', compact('insurances'));
        }
    }
    /* insurance name store */
    public function insName(Request $request)
    {
        $insurance['name'] = $request->input('name');
        $insurance['alias'] = $request->input('alias');
        // dd($insurance);
        session()->put('insurance', $insurance);
        return redirect()->route('request.callback.insurance');
    }

    public function callBackInsurance(Request $request)
    {
        session()->flash('module', 'store');
        $cart = session()->get('insurance');

        $name = $cart['name'];
        $alias =  $cart['alias'];
        // dd($alias);

        return view('front.insurance.request-call-back-form-insurance', compact('name'));
    }

    /* insurance enquiry store */
    public function AddInsEnquiry(Request $request)
    {
        $rules =  [
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile_number' => 'required',
            'email' => 'required',
        ];
        $validatedData = $request->validate($rules);
        $cart = session()->get('insurance');
        $alias = $cart['alias'];

        if($alias=='hire_car'|| $alias=='hire_bus')
        {
            $PostData = $request->all();
            $PostData['status'] = 'Open';
            $PostData['hire_name'] = $alias;
            $hire_Enquiry = HireEnquiry::create($PostData);
            if ($hire_Enquiry) {
                session()->flash('success', 'Your Enquiry is added. Respective Person contact you.');
            }
            if ($alias == 'hire_car') {
                return redirect()->route('hire.cab');
            } elseif ($alias == 'hire_bus') {
                return redirect()->route('hire.bus');
            }
        }

        $PostData = $request->all();
        $PostData['status'] = 'Open';
        $PostData['insurance_alias'] = $alias;
        $Insurance_Enquiry = Insurance_Enquiry::create($PostData);
        if ($Insurance_Enquiry) {
            session()->flash('success', 'Your Enquiry is added. Respective Person contact you.');
        }
        return redirect()->route('insurance');
    }
}
