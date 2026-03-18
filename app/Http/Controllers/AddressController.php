<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use App\Models\Log;

class AddressController extends Controller
{
    public function myAddress()
    {
        session()->flash('module', 'my_address');
        $user_id =  Auth::user()->id;
        $address = new Address();
        $address_list = $address->where('user_id',$user_id)->orderBy('id','DESC')->get();
        return view('front.address.my_address', compact('address_list'));
    }

    public function addAddress()
    {
        $addressData = new Address;
        $title = "Add";
        $actionUrl = "{{ route('store.address') }}";
        return view('front.address.add_address', compact('addressData', 'title', 'actionUrl'));
    }

    public function store(Request $request)
    {        
        $PostData = $request->all();
        $address = $this->save_add($request);
        
        $PostData['user_id'] = Auth::user()->id;
        $logData['type'] = "add_address";
        $logData['data'] = json_encode($PostData);
        Log::create($logData);

        if($address) {
            session()->flash('success', 'Address successfully Added.');
        } else {
            session()->flash('error', 'Address Not Added');
        }
        return redirect()->route('address');
    }

    public function edit($id)
    {
        $addressData = Address::find($id);
        $title = "Update";
        $actionUrl = "{{ route('update.address') }}";

        return view('front.address.add_address',compact('addressData','title','actionUrl'));
    }

    public function update(Request $request)
    {       
        $address = $this->save_add($request);
        $PostData = $request->all();
        $PostData['user_id'] = Auth::user()->id;
        $logData['type'] = "update_vehicle";
        $logData['data'] = json_encode($PostData);
        Log::create($logData);        
        session()->flash('success', 'Address successfully updated.');
        return redirect()->route('address');
    }


    public function AddressForm($id = null)
    {
        if(isset($id)){
            $addressData = Address::find($id);
            $title = "Update";
        } else {
            $addressData = new Address();
            $title = "Add";
        }  
        $page = view('front.address.addressModal',compact('addressData','title'))->render();
        return response()->json(['page' => $page]);
    }

    public function save(Request $request)
    {
        $this->save_add($request);
        return redirect()->route('checkout');
    }
    private function save_add(Request $request)
    {
        $rules =  [
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile_number' => 'required',
            'email' => 'required',
            'add1' => 'required',
            'pincode' => 'required',
            'state' => 'required',
            'city' => 'required',
        ];

        $validatedData = $request->validate($rules);
        $PostData = $request->all();

        if(isset($PostData['is_default']) && $PostData['is_default'] == 1){
            Address::where('user_id', $PostData['user_id'])->update(['is_default' => 0]);
        }
        if(isset($PostData['id']) && !empty($PostData['id'])){
            $id = $request->input('id');
            $existingAddress = Address::find($id);
            $existingAddress->update($PostData);
            $add_id = $id;
            session()->flash('success', 'Address successfully updated.');
        }else{
            $address = Address::create($PostData);
            $add_id = $address->id;
            session()->flash('success', 'Address successfully Added.');
        }  
        
        return true;
    }

    public function delete($id)
    {
        $address = Address::find($id); 
        $address->delete();
        return response()->json(['message' => 'Address deleted successfully']);
    }

    public function SetAddressSession(Request $request)
    {
        // $cart = session()->get('road_sathi_address_id', []);
        $id =  $request->input('address_id');
        session()->put('road_sathi_address_id', $id);
        return response()->json([]);
    }
}
