<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;

class AdminProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('product_image')->orderBy('id', 'asc')->get();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productObj = new Product();
        return view('admin.products.create', compact('productObj'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product = new Product();
        $store = $product->create($request->all());
        if($store){
            $productimages = [];
            if ($request->hasFile('image')) {
                // $this->validate($request, [
                //         'image' => 'required|image|mimetypes:image/jpeg,image/png,image/jpg,image/gif|max:2048',
                //     ]);
                $images = $request->file('image');
                foreach($images as $key => $image){
                    $destinationPath = public_path('uploads/ProductImage');
                    $profileImage = date('YmdHis').$key.'.'.$image->getClientOriginalExtension();
                    $image->move($destinationPath, $profileImage);
                    $productimages[$key]['product_id'] =   $store->id;
                    $productimages[$key]['image'] =   $profileImage;
                }
                ProductImage::insert($productimages);
            }
        }
        if($store){
            return redirect()->to('admin/products')->with('success', "Data Save Successfully");
        }else{
            return redirect()->to('admin/products')->with('error','Something is wrong');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $productObj = Product::where('id', $id)->first();
        return view('admin.products.edit', compact('productObj'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::where('id', $id)->first();
        $store = $product->update($request->all());
        if($store){
            $productimage = ProductImage::where('product_id', $id)->first();
            if($productimage == '' || $productimage == null){
                $productimages = [];
                if ($request->hasFile('image')) {
                    $images = $request->file('image');
                    foreach($images as $key => $image){
                        $destinationPath = public_path('uploads/ProductImage');
                        $profileImage = date('YmdHis').$key.'.'.$image->getClientOriginalExtension();
                        $image->move($destinationPath, $profileImage);
                        $productimages[$key]['product_id'] =   $id;
                        $productimages[$key]['image'] =   $profileImage;
                    }
                    ProductImage::insert($productimages);
                }
            }else{
                if ($request->hasFile('image')) {
                    $images = $request->file('image');
                    foreach($images as $key => $image){
                        $destinationPath = public_path('uploads/ProductImage');
                        $profileImage = date('YmdHis').$key.'.'.$image->getClientOriginalExtension();
                        $image->move($destinationPath, $profileImage);
                        $productimage->image = $profileImage;
                    }
                    $productimage->update();
                }
            }
        }
        if($store){
            return redirect()->to('admin/products')->with('success', "Data Update Successfully");
        }else{
            return redirect()->to('admin/products')->with('error','Something is wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::where('id', $id)->delete();
        $ProductImage = ProductImage::where('product_id', $id)->get();
        if(isset($productimage))
        {
            foreach ($productimage as $key => $value) {
                $image = $value->image;
                if(!empty($image))
                {
                    if(file_exists(public_path('/uploads/ProductImage/'.$image)))
                    {
                        unlink(public_path('/uploads/ProductImage/'.$image));
                    }
                }
                $value->delete();
            }
        }
        return $product;
    }

    public function updateProductStatus(Request $request)
    {
        $product = Product::where('id', $request->input('id'))->first();
        $product->status  = $request->input('status');
        $product->update();
        return $product;
    }
}
