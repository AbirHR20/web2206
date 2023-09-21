<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    function coupon() {
        $coupons = Coupon::all();
        return view('admin.coupon.coupon',[
            'coupons'=>$coupons,
        ]);
    }
    function coupon_store(Request $request) {
        $request->validate([
            'coupon'=>'required',
            'type'=>'required',
            'amount'=>'required',
            'limit'=>'required',
            'validity'=>'required',
        ]);
        Coupon::insert([
            'coupon'=>$request->coupon,
            'type'=>$request->type,
            'amount'=>$request->amount,
            'limit'=>$request->limit,
            'validity'=>$request->validity,
            'created_at'=>Carbon::now(),
        ]);
        return back()->with('coupon','Coupon Added!');
    }
}
