<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Insurance_Enquiry;
use App\Models\Insurance;
use Auth;

class CartController extends Controller
{

    public function index()
    {
        session()->flash('module', 'store');
        return view('front.store');
    }
    /* cart add */
    public function AddToCart(Request $request)
    {
        $cart = session()->get('road_sathi_cart');
        $quantity =  $request->input('quantity');
        $wheeler =  $request->input('wheeler_type');

        // dd(session()->get('road_sathi_cart'));
        if (!empty($cart)) {

            if(isset($cart['products'][$wheeler])){
                $cart['products'][$wheeler] = $cart['products'][$wheeler] + $quantity;
            }else{
                $cart['products'][$wheeler] =  $quantity;
            }
        } else {
            $cart['products'][$wheeler] = $quantity;
        }

        // pre($cart);exit;
        unset($cart['quantity']);
        session()->put('road_sathi_cart', $cart);
        return redirect()->route('cart');

    }

    /* update cart */
    public function updateCart(Request $request)
    {
        $cart = session()->get('road_sathi_cart');

        $wheeler =  $request->input('type');
        $quantity =  $request->input('quantity');

        $cart['quantity'] = $quantity;

        if(isset($cart['products'][$wheeler])){
            $cart['products'][$wheeler] =  $quantity;
        }else{
            $cart['products'][$wheeler] =  $quantity;
        }

        session()->put('road_sathi_cart', $cart);

        $total_qnt = array_sum($cart['products']);
        $price = $total_qnt * RS_SAFETY_PRICE;
        $data['AvailableBarcode'] = AvailableBarcode();
        if(isset($cart['code'])){
            $discount = GetDiscount($cart['code'],$total_qnt,$price);
            $data['discount'] = $discount;
        }else{
            $discount = '';
            $data['discount']= '';
        }
        return response()->json($data);
    }

    /* quantity check */
    public function checkQnt(Request $request)
    {
        $data['AvailableBarcode'] = AvailableBarcode();
        dd($data['AvailableBarcode']);
        // $data['DiscountData'] = GetDiscount();
        return response()->json($data);
    }

    public function cart(Request $request)
    {
        return view('front.cart');
    }

    /* quantity remove */
    public function remove(Request $request)
    {
        // $cart['quantity'] = 0;
        // $cart = session()->put('road_sathi_cart', $cart);
        // session()->put('road_sathi_checkout', []);
        // session()->flash('success', 'Product successfully removed!');
        $key = $request->input('name');
        // dd($key);
        $cart = session()->get('road_sathi_cart');

        // Update the quantity for the item with the given key to 0
        if (isset($cart['products'][$key])) {
            $cart['products'][$key] = 0;
            session()->put('road_sathi_cart', $cart);
            session()->put('road_sathi_checkout', []);
            session()->flash('success', 'Product successfully removed!');
        } else {
            session()->flash('error', 'Product not found in the cart.');
        }

        // Redirect back to the previous page or any desired route
        return redirect()->back();
    }
    /* checkout page add quantity and price */
    public function GoToCheckout(Request $request)
    {
        $checkout_data['price'] = $request->input('final_price');
        $checkout_data['quantity'] = $request->input('final_quantity');
        $checkout_data['promocode'] = '';
        $checkout_data['discount'] =  '';

        $promocode = $request->input('promocode');
        $discount =  GetDiscount($promocode, $request->input('final_quantity'),$request->input('final_price'));
        if($discount){
            $checkout_data['promocode'] = $request->input('promocode');
            $checkout_data['discount'] =  $request->input('discount');
        }else{
            $checkout_data['discount'] =  $request->input('discount');
        }
        session()->put('road_sathi_checkout', $checkout_data);
        return redirect()->route('checkout');
    }
    /* checkout page  */
    public function checkout()
    {
        if(!isset(Auth::user()->id)){
            return redirect()->route('login');
            exit;
        }
        $cart = session()->get('road_sathi_checkout');

        if(!empty($cart)){
            $quantity = $cart['quantity'];
            $price = $cart['price'];

            $promocode = $cart['promocode'];
            $discount =  GetDiscount($promocode, $quantity,$price);
            if($discount){
                $discount = $discount;
                $code = $promocode;
            }else{
                $discount = 0;
                $code = '';
            }
            return response()->view('front.checkout', compact('price','quantity','discount','code'))->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        }else{
            return redirect()->route('cart');
        }

        // if(count($request->all()) >= 1)
        // {
        //     $price = $request->input('final_price');
        //     $quantity = $request->input('final_quantity');
        //     return view('front.checkout', compact('price','quantity'));
        // }
        // else {
        //     $cart = session()->get('road_sathi_cart', []);
        //     if(!empty($cart)){
        //         $quantity = $cart['quantity'];
        //         $price = $quantity * 500;
        //         return view('front.checkout', compact('price','quantity'));
        //     }else{
        //         return redirect()->route('cart');
        //     }
        // }
    }
    /* promocode model */
    public function GetPromoCode(Request $request)
    {
        $qnt = $request->quantity;
        $total_price = $request->price;
        $applied_code = $request->code;
        $Promocode = GetPromoCode($qnt,$total_price);
        $page = view('front.PromodCodeModal',compact('Promocode','qnt','total_price','applied_code'))->render();
        $applied_code = $request->code;
        $Promocode = GetPromoCode($qnt,$total_price);
        $page = view('front.PromodCodeModal',compact('Promocode','qnt','total_price','applied_code'))->render();
        return response()->json(['page' => $page]);
    }

    /* Promocode Calculate */
    public function SetPromoCode(Request $request)
    {
        $postdata = $request->all();
        if(!empty($postdata)){
            $code = $request->code;
            $road_sathi_cart = session()->get('road_sathi_cart');
            $road_sathi_cart['code'] = $code;
            session()->put('road_sathi_cart',$road_sathi_cart);
            $road_sathi_cart['code'] = $code;
        }else{
            $road_sathi_cart = session()->get('road_sathi_cart');
            $road_sathi_cart['code'] = '';
            session()->put('road_sathi_cart',$road_sathi_cart);
        }
        return response()->json();
    }
    /* promocode Check */
    public function CheckPromoCode(Request $request)
    {
        $code = $request->code;
        $price = $request->price;
        $quantity =  $request->quantity;
        $discount =  GetDiscount($code,$quantity,$price);
        if($discount != ''){
            $result = true;
        }else{
            $result = false;
        }
        return response()->json(['result' => $result]);
    }
}
