<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    function cart_store(Request $request)
    {
        $request->validate([
            'color_id' => 'required',
            'size_id' => 'required',
        ]);

        if (Cart::where('customer_id', Auth::guard('customer')->id())->where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->exists()) {
            Cart::where('customer_id', Auth::guard('customer')->id())->where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->increment('quantity', $request->quantity);
            return back()->with('cart_added', 'Cart Added Sucessfully!');
        } else {
            Cart::insert([
                'customer_id' => Auth::guard('customer')->id(),
                'product_id' => $request->product_id,
                'color_id' => $request->color_id,
                'size_id' => $request->size_id,
                'quantity' => $request->quantity,
                'created_at' => Carbon::now(),
            ]);
            return back()->with('cart_added', 'Cart Added Sucessfully!');
        }
    }
    function cart_remove($id) {
        Cart::find($id)->delete();
        return back();
    }
    function cart() {
        $carts = Cart::where('customer_id',Auth::guard('customer')->id())->get();
        return view('frontend.cart',[
            'carts'=>$carts,
        ]);
    }
    function cart_update(Request $request) {
        foreach ($request->quantity as $cart_id=>$quantity) {
            Cart::find($cart_id)->update([
                'quantity'=> $quantity,
            ]);
        }
        return back();
    }
}
