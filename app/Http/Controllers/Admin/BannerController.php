<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        $banner_Obj =  new Banner();
        $banners =  Banner::latest()->get();
        if (isset($request->uid) && $request->uid != '') {
            $banner_Obj = Banner::where('id', $request->uid)->first();
        }
        return view('admin.banner.index', compact('banners', 'banner_Obj'));
    }

    public function store(Request $request)
    {
        $message = "";
        if ($request->uid == '' || $request->uid == null) {
            $this->validate($request, [
                'name' => 'required|string',
                'image' => 'required|max:2048'
            ]);

            $banner =  new Banner();
            $banner->name  = $request->name;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $destinationPath = public_path('uploads/BannerImage');
                $profileImage = date('YmdHis') . '.' . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $banner->image =   $profileImage;
            }
            $store = $banner->save();
            $message = "Data Add Successfully";
        } else {

            $this->validate($request, [
                'name' => 'required|string',
                'image' => 'required|max:2048'
            ]);
            $banner = Banner::where('id', $request->uid)->first();
            $banner->name  = $request->name;
            if ($request->hasFile('image')) {
                if(file_exists(public_path('/uploads/BannerImage/'.$banner->image)))
                {
                    unlink(public_path('/uploads/BannerImage/'.$banner->image));
                }
                $image = $request->file('image');
                $destinationPath = public_path('uploads/BannerImage');
                $profileImage = date('YmdHis') . '.' . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $banner->image = $profileImage;
            }

            $store = $banner->update();
            $message = "Data update Successfully";
        }

        if ($store) {
            return redirect()->to('admin/banner')
                ->with('success', $message);
        } else {
            return redirect()->to('admin/banner')
                ->with('error', 'Something is wrong');
        }
    }

    public function destroy($id)
    {
        $banner = Banner::find($id);
        if(file_exists(public_path('/uploads/BannerImage/'.$banner->image)))
        {
            unlink(public_path('/uploads/BannerImage/'.$banner->image));
        }
        $banner->delete();
        return redirect()->back()->with('success', 'Banner deleted successfully');
    }

    public function updateBannerStatus(Request $request)
    {
        $id = $request->input('id');
        $banner = Banner::where('id', $id)->first();
        $banner->status = $request->input('status');
        $banner->update();
        return $banner;
    }
}
