<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Size;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    function variation() {
        $colors = Color::all();
        $categories = Category::all();
        return view('admin.product.variation',[
            'colors'=>$colors,
            'categories'=>$categories,         
        ]);
    }
    function color_store(Request $request){
        Color::insert([
            'color_name'=>$request->color_name,
            'color_code'=>$request->color_code,
            'created_at'=>Carbon::now(),
        ]);
        return back()->with('success','Color Added!');
    }   
    function size_store(Request $request){
        Size::insert([
            'size_name'=>$request->size_name,
            'category_id'=>$request->category_id,
            'created_at'=>Carbon::now(),
        ]);
        return back()->with('size','Size Added!');
    } 
    function color_remove($id) {
        Color::find($id)->delete();
        return back()->with('color_remove','Color Removed!');
    }  
    function size_remove($id) {
        Size::find($id)->delete();
        return back()->with('size_remove','Size Removed!');
    } 
    function inventory($id) {
        $product = Product::find($id);
        $colors = Color::all();
        return view('admin.product.inventory',[
            'product'=>$product,
            'colors'=>$colors,
        ]);
    } 
    function inventory_store(Request $request,$id){
        Inventory::insert([
            'product_id'=>$id,
            'color_id'=>$request->color_id,
            'size_id'=>$request->size_id,
            'quantity'=>$request->quantity,
            'created_at'=>Carbon::now(),
        ]);
        return back()->with('inventory','Inventory Added!');
    }
}
