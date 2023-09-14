<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    function index()
    {
        $categories = Category::all();
        $products = Product::where('status', 1)->latest()->get();
        return view('frontend.index', [
            'categories' => $categories,
            'products' => $products,
        ]);
    }
    function category_products($id)
    {
        $categories = Category::find($id);
        $product_categories = Product::where('category_id', $id)->get();
        return view('frontend.category_products', [
            'product_categories' => $product_categories,
            'categories' => $categories,
        ]);
    }
    function subcategory_products($id)
    {
        $subcategories = Subcategory::find($id);
        $product_subcategories = Product::where('subcategory_id', $id)->get();
        return view('frontend.subcategory_products', [
            'product_subcategories' => $product_subcategories,
            'subcategories' => $subcategories,
        ]);
    }
    function products_details($slug)
    {
        $product_id = Product::where('slug', $slug)->first()->id;
        $product_details = Product::find($product_id);
        $avilable_colors = Inventory::where('product_id', $product_id)->groupBy('color_id')->selectRaw('count(*) as total,color_id')->get();
        $avilable_sizes = Inventory::where('product_id', $product_id)->groupBy('size_id')->selectRaw('count(*) as total,size_id')->get();
        return view('frontend.product_details', [
            'product_details' => $product_details,
            'avilable_colors' => $avilable_colors,
            'avilable_sizes' => $avilable_sizes,
        ]);
    }
    function getSize(Request $request)
    {
        $str = '';
        $sizes = Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->get();
        foreach ($sizes as $size) {
            $str .= '<li class=""><input class="size_id" id="size' . $size->size_id . '" type="radio"
            name="size_id" value="' . $size->size_id . '">
            <label
                                                    for="size' . $size->size_id . '">' . $size->rel_to_size->size_name . '</label></li>';
        }
        echo $str;
    }
    function getQuantity(Request $request) {
        $str = '';
        $quantity = Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->first()->quantity;
        if ($quantity == 0) {
            $quantity = '<button class="btn btn-danger">Out of stock</button>';
        } else {
            $quantity = '<button class="btn btn-success">'.$quantity.' in stock</button>';
        }
        echo $quantity; 
    }
}
