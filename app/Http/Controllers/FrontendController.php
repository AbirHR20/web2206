<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Inventory;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Size;
use App\Models\Subcategory;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $product_categories = Product::where('category_id', $id)->where('status', 1)->get();
        return view('frontend.category_products', [
            'product_categories' => $product_categories,
            'categories' => $categories,
        ]);
    }
    function subcategory_products($id)
    {
        $subcategories = Subcategory::find($id);
        $product_subcategories = Product::where('subcategory_id', $id)->where('status', 1)->get();
        return view('frontend.subcategory_products', [
            'product_subcategories' => $product_subcategories,
            'subcategories' => $subcategories,
        ]);
    }
    function products_details($slug)
    {
        $product_id = Product::where('slug', $slug)->first()->id;
        $reviews = OrderProduct::where('product_id', $product_id)->whereNotNull('review')->get();
        $total_stars = OrderProduct::where('product_id', $product_id)->whereNotNull('review')->sum('star');
        $product_details = Product::find($product_id);
        $avilable_colors = Inventory::where('product_id', $product_id)->groupBy('color_id')->selectRaw('count(*) as total,color_id')->get();
        $avilable_sizes = Inventory::where('product_id', $product_id)->groupBy('size_id')->selectRaw('count(*) as total,size_id')->get();
        return view('frontend.product_details', [
            'product_details' => $product_details,
            'avilable_colors' => $avilable_colors,
            'avilable_sizes' => $avilable_sizes,
            'reviews' => $reviews,
            'total_stars' => $total_stars,
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
    function getQuantity(Request $request)
    {
        $quantity = Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->first()->quantity;
        if ($quantity == 0) {
            $quantity = '<button class="abc btn btn-danger" value="' . $quantity . '">Out of stock</button>';
        } else {
            $quantity = '<button class="btn btn-success">' . $quantity . ' in stock</button>';
        }
        echo $quantity;
    }
    function review_store(Request $request)
    {
        OrderProduct::where('customer_id', Auth::guard('customer')->id())->where('product_id', $request->product_id)->first()->update([
            'review' => $request->review,
            'star' => $request->stars,
            'updated_at' => Carbon::now(),
        ]);
        return back();
    }
    function shop(Request $request)
    {
        $data = $request->all();
        $sorting = 'created_at';
        $type = 'DESC';
        if (!empty($data['sorting']) && $data['sorting'] != '' && $data['sorting'] != 'undefined') {
            if ($data['sorting'] == 1) {
                $sorting = 'after_product_discount';
                $type = 'ASC';
            } elseif ($data['sorting'] == 2) {
                $sorting = 'after_product_discount';
                $type = 'DESC';
            }
        }
        $products = Product::where(function ($q) use ($data) {
            $min = 0;
            $max = Product::max('after_product_discount');
            if (!empty($data['min']) && $data['min'] != '' && $data['min'] != 'undefined') {
                $min = $data['min'];
            }
            if (!empty($data['max']) && $data['max'] != '' && $data['max'] != 'undefined') {
                $max = $data['max'];
            }
            if (!empty($data['search_input']) && $data['search_input'] != '' && $data['search_input'] != 'undefined') {
                $q->where(function ($q) use ($data) {
                    $q->where('product_name', 'LIKE', '%' . $data['search_input'] . '%');
                    $q->orWhere('short_desp', 'LIKE', '%' . $data['search_input'] . '%');
                    $q->orWhere('long_desp', 'LIKE', '%' . $data['search_input'] . '%');
                });
            }
            if (!empty($data['category_id']) && $data['category_id'] != '' && $data['category_id'] != 'undefined') {
                $q->where(function ($q) use ($data) {
                    $q->where('category_id', $data['category_id']);
                });
            }
            if (!empty($data['tag_id']) && $data['tag_id'] != '' && $data['tag_id'] != 'undefined') {
                $q->where(function ($q) use ($data) {
                    $all = '';
                    foreach (Product::all() as $pro) {
                        $explode = explode(',', $pro->tages);
                        if (in_array($data['tag_id'], $explode)) {
                            $all .= $pro->id . ',';
                        }
                    }
                    $explode2 = explode(',', $all);
                    $q->find($explode2);
                });
            }
            if (!empty($data['category2_id']) && $data['category2_id'] != '' && $data['category2_id'] != 'undefined') {
                $q->where(function ($q) use ($data) {
                    $q->where('category_id', $data['category2_id']);
                });
            }
            if (!empty($data['color_id']) && $data['color_id'] != '' && $data['color_id'] != 'undefined') {
                $q->whereHas('rel_to_inventory', function ($q) use ($data) {
                    if (!empty($data['color_id']) && $data['color_id'] != '' && $data['color_id'] != 'undefined') {
                        $q->whereHas('rel_to_color', function ($q) use ($data) {
                            $q->where('color_id', $data['color_id']);
                        });
                    }
                });
            }
            if (!empty($data['color_id']) && $data['color_id'] != '' && $data['color_id'] != 'undefined' && !empty($data['size_id']) && $data['size_id'] != '' && $data['size_id'] != 'undefined') {
                $q->whereHas('rel_to_inventory', function ($q) use ($data) {
                    if (!empty($data['color_id']) && $data['color_id'] != '' && $data['color_id'] != 'undefined') {
                        $q->whereHas('rel_to_color', function ($q) use ($data) {
                            $q->where('color_id', $data['color_id']);
                        });
                    }
                    if (!empty($data['size_id']) && $data['size_id'] != '' && $data['size_id'] != 'undefined') {
                        $q->whereHas('rel_to_size', function ($q) use ($data) {
                            $q->where('size_id', $data['size_id']);
                        });
                    }
                });
            }
            if (!empty($data['min']) && $data['min'] != '' && $data['min'] != 'undefined' || !empty($data['max']) && $data['max'] != '' && $data['max'] != 'undefined') {
                $q->whereBetween('after_product_discount', [$min, $max]);
            }
        })->orderBy($sorting, $type)->get();
        $categories = Category::all();
        $colors = Color::all();
        $sizes = Size::all();
        $tags = Tag::all();
        return view('frontend.shop', [
            'products' => $products,
            'categories' => $categories,
            'colors' => $colors,
            'sizes' => $sizes,
            'tags' => $tags,
        ]);
    }
}
