<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function index(Request $request)
    {       
        $discount = Discount::first();
        if(!$discount){
            $discount = new Discount();
        }
        return view('admin.discount', compact('discount'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'quantity' => 'required',
            'discount' => 'required'
        ]);
        $postData = $request->all();
        $postData['type'] = 'percentage';

        $message = "";
        if ($request->id == '' || $request->id == null) {
            unset($postData['id']);
            $store = Discount::create($postData);
            $message = "Data Add Successfully";
        } else {           
            $discount = Discount::find($request->id);     
            $store = $discount->update($postData);
            $message = "Data update Successfully";
        }

        if ($store) {
            return redirect()->to('admin/discount')
                ->with('success', $message);
        } else {
            return redirect()->to('admin/discount')
                ->with('error', 'Something is wrong');
        }
    }
}
