<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\wishlist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishListController extends Controller
{
    function wishlist_remove($id) {
        wishlist::find($id)->delete();
        return back();
    }

    function wishlist()  {
        $wishlists = wishlist::where('customer_id',Auth::guard('customer')->id())->get();
        return view('frontend.wishlist',[
            'wishlists'=>$wishlists,
        ]);
    }

    function wish_cart($id) {
        $info = wishlist::find($id);
        Cart::insert([
            'customer_id'=>$info->customer_id,
            'product_id'=>$info->product_id,
            'color_id'=>$info->color_id,
            'size_id'=>$info->size_id,
            'quantity'=>$info->quantity,
            'created_at'=>Carbon::now(),
        ]);
        wishlist::find($id)->delete();
        return back()->with('cart_added', 'Cart Added Sucessfully!');
    }
}
