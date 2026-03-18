<?php

namespace App\Http\Controllers;

use App\Models\HireEnquiry;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\ProductImage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('product_image')->orderBy('id', 'asc')->where('status', 1)->get();

        // dd($products);
        return view('products', compact('products'));
    }

    public function cart()
    {
        return view('cart');
    }

    public function addToCart()
    {
        // $product = Product::with('product_image')->findOrFail($id);
        $cart = session()->get('cart', []);
        if (isset($cart)) {
            $cart['quantity']++;
        } else {
            $cart['quantity'] = 1;
        }
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product add to cart successfully!');
    }

    public function update(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Cart successfully updated!');
        }
    }

    public function remove(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Product successfully removed!');
        }
    }
}
