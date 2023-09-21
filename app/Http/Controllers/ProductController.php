<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    function product()
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $brands = Brand::all();
        return view('admin.product.product', [
            'categories' => $categories,
            'subcategories' => $subcategories,
            'brands' => $brands,
        ]);
    }

    function getSubcategory(Request $request)
    {
        $str = '<option value="">select sub category</option>';
        $subcategories = Subcategory::where('category_id', $request->category_id)->get();
        foreach ($subcategories as $subcategory) {
            $str .= '<option value="' . $subcategory->id . '">' . $subcategory->subcategory_name . '</option>';
        }
        echo $str;
    }
    function product_store(ProductRequest $request)
    {
        $tags = $request->tags;
        $after_implode = implode(',', $tags);
        $preview = $request->preview;
        $extension = $preview->extension();
        $file_name = Str::lower(str_replace('', '-', $request->product_name)) . '-' . random_int(100000, 900000) . '.' . $extension;
        Image::make($preview)->save(public_path('uploads/product/preview/' . $file_name));
        $product_id = Product::insertGetId([
            'category_id' => $request->category,
            'subcategory_id' => $request->subcategory,
            'brand_id' => $request->brand,
            'product_name' => $request->product_name,
            'product_price' => $request->product_price,
            'product_discount' => $request->product_discount,
            'after_product_discount' => $request->product_price - ($request->product_price * $request->product_discount / 100),
            'tages' => $after_implode,
            'short_desp'=> $request->short_desp,
            'long_desp' => $request->long_desp,
            'add_info' => $request->add_info,
            'preview' => $file_name,
            'slug' => Str::lower(str_replace('', '-', $request->product_name)) . '-' . random_int(10000000, 90000000),
            'created_at' => Carbon::now(),
        ]);
        foreach ($request->gallery as  $gal) {
            $extension = $gal->extension();
            $file_name = Str::lower(str_replace('', '-', $request->product_name)) . '-' . random_int(100000, 900000) . '.' . $extension;
            Image::make($gal)->save(public_path('uploads/product/gallery/' . $file_name));
            ProductGallery::insert([
                'product_id'=> $product_id,
                'gallery'=> $file_name,
            ]);
        }
        return back()->with('success', 'product added!');
    }
    function product_list() {
        $products = Product::all();
        return view('admin.product.list',[
            'products'=>$products,
        ]);
    }
    function product_delete($id) {
        $product = Product::find($id);
        $gallery = ProductGallery::where('product_id',$id)->get();
        $preview = public_path('uploads/product/preview/'.$product->preview);
        unlink($preview);
        foreach ($gallery as $gal) {
            $gal_img = public_path('uploads/product/gallery/'.$gal->gallery);
            unlink($gal_img);
            ProductGallery::find($gal->id)->delete();
        }
        Product::find($id)->delete();

        $inventories = Inventory::where('product_id',$id)->get();
        foreach ($inventories as  $inventory) {
            Inventory::find($inventory->id)->delete();
        }

        return back();
    }
    function product_show($id) {
        $product = Product::find($id);
        $galleries = ProductGallery::where('product_id',$id)->get();
        return view('admin.product.show',[
            'product'=>$product,
            'galleries'=>$galleries,
        ]);
    }
    function changeStatus(Request $request) {
        Product::find($request->product_id)->update([
            'status'=>$request->status,
        ]);
    }
    function couponChangeStatus(Request $request){
        Coupon::find($request->coupon_id)->update([
            'status'=>$request->status,
        ]);
    }
    function coupon_delete($id) {
        Coupon::find($id)->delete();
        return back();
    }
}
