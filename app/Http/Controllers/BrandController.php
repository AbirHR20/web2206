<?php

namespace App\Http\Controllers;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use App\Models\Brand;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    function brand() {
        $brand = Brand::all();
        return view('admin.Brand.brand',[
            'brand'=>$brand,
        ]);
    }
    function brand_store(Request $request) {
        $request->validate([
            'brand_name'=>'required',
            'brand_logo'=>'required|image',
        ]);
        $logo = $request->brand_logo;
        $extension = $logo->extension();
        $file_name = Str::lower(str_replace('','-',$request->brand_name)).'.'.$extension;
        Image::make($logo)->save(public_path('uploads/brand/'.$file_name));
        Brand::insert([
            'brand_name'=>$request->brand_name,
            'brand_logo'=>$file_name,
            'created_at'=>Carbon::now(),
        ]);
        return back()->with('success','New Brand Added!');
    }
}
