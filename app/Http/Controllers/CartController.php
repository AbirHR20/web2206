<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Inventory;
use App\Models\wishlist;
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

        if ($request->btn == 1) {
            if (Cart::where('customer_id', Auth::guard('customer')->id())->where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->exists()) {
                Cart::where('customer_id', Auth::guard('customer')->id())->where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->increment('quantity', $request->quantity);
                return back()->with('cart_added', 'Cart Added Sucessfully!');
            } else {
                $quantity = Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->first()->quantity;
                if ($quantity >= $request->quantity) {
                    Cart::insert([
                        'customer_id' => Auth::guard('customer')->id(),
                        'product_id' => $request->product_id,
                        'color_id' => $request->color_id,
                        'size_id' => $request->size_id,
                        'quantity' => $request->quantity,
                        'created_at' => Carbon::now(),
                    ]);
                    return back()->with('cart_added', 'Cart Added Sucessfully!');
                } else {
                    return back()->with('out', "Quantity stock on $quantity");
                }
            }
        } else {
            if (wishlist::where('customer_id', Auth::guard('customer')->id())->where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->exists()) {
                wishlist::where('customer_id', Auth::guard('customer')->id())->where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->increment('quantity', $request->quantity);
                return back()->with('wish_added', 'Added to wishlist!');
            } else {
                $quantity = Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->first()->quantity;
                if ($quantity >= $request->quantity) {
                    wishlist::insert([
                        'customer_id' => Auth::guard('customer')->id(),
                        'product_id' => $request->product_id,
                        'color_id' => $request->color_id,
                        'size_id' => $request->size_id,
                        'quantity' => $request->quantity,
                        'created_at' => Carbon::now(),
                    ]);
                    return back()->with('wish_added', 'Added to wishlist!');
                } else {
                    return back()->with('out', "Quantity stock on $quantity");
                }
            }
        }
    }
    function cart_remove($id)
    {
        Cart::find($id)->delete();
        return back();
    }
    function cart(Request $request)
    {
        $coupon = $request->coupon;
        $msg = '';
        $type = '';
        $discount = 0;
        if (isset($coupon)) {
            if (Coupon::where('coupon', $coupon)->exists()) {
                if (Carbon::now()->format('Y-m-d') <= Coupon::where('coupon', $coupon)->first()->validity) {
                    if (Coupon::where('coupon', $coupon)->first()->limit != 0) {
                        $type = Coupon::where('coupon', $coupon)->first()->type;
                        $discount = Coupon::where('coupon', $coupon)->first()->amount;
                    } else {
                        $msg = 'coupon limit expired!';
                        $discount = 0;
                    }
                } else {
                    $msg = 'coupon code expired!';
                    $discount = 0;
                }
            } else {
                $msg = 'Invalid coupon code!';
                $discount = 0;
            }
        }
        $carts = Cart::where('customer_id', Auth::guard('customer')->id())->get();
        return view('frontend.cart', [
            'carts' => $carts,
            'msg' => $msg,
            'discount' => $discount,
            'type' => $type,
        ]);
    }
    function cart_update(Request $request)
    {
        foreach ($request->quantity as $cart_id => $quantity) {
            Cart::find($cart_id)->update([
                'quantity' => $quantity,
            ]);
        }
        return back();
    }
}
