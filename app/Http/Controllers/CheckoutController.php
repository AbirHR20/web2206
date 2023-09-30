<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\Cart;
use App\Models\City;
use App\Models\Country;
use App\Models\Order;
use App\Models\Shipping;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    function checkout()
    {
        $countries = Country::all();
        $carts = Cart::where('customer_id', Auth::guard('customer')->id())->get();
        return view('frontend.customer.checkout', [
            'carts' => $carts,
            'countries' => $countries,
        ]);
    }
    function getCity(Request $request)
    {
        $cities = City::where('country_id', $request->countryId)->get();
        $str = '<option disabled="" selected="">Select city</option>';
        foreach ($cities as  $city) {
            $str .= '<option value="' . $city->id . '" >' . $city->name . '</option>';
        }
        echo $str;
    }
    function order_store(Request $request)
    {
        $request->validate([
            'payment_method' => 'required',
            'charge' => 'required',
        ]);
        if ($request->payment_method == 1) {
            $order_id = '#' . uniqid() . '-' . Carbon::now()->format('Y-m-d');
            Order::insert([
                'order_id' => $order_id,
                'customer_id' => Auth::guard('customer')->id(),
                'discount' => $request->discount,
                'charge' => $request->charge,
                'payment_method' => $request->payment_method,
                'sub_total' => $request->sub_total,
                'total' => ($request->sub_total + $request->charge) - $request->discount,
                'created_at' => Carbon::now(),
            ]);
            Billing::insert([
                'order_id' => $order_id,
                'customer_id' => Auth::guard('customer')->id(),
                'fname' => $request->fname,
                'lname' => $request->lname,
                'country_id' => $request->country,
                'city_id' => $request->city,
                'zip' => $request->zip,
                'email' => $request->email,
                'company' => $request->company,
                'phone' => $request->phone,
                'address' => $request->address,
                'message' => $request->message,
                'created_at' => Carbon::now(),
            ]);
            if ($request->ship_check == 1) {
                Shipping::insert([
                    'order_id' => $order_id,
                    'customer_id' => Auth::guard('customer')->id(),
                    'ship_fname' => $request->ship_fname,
                    'ship_lname' => $request->ship_lname,
                    'ship_country_id' => $request->ship_country,
                    'ship_city_id' => $request->ship_city,
                    'ship_zip' => $request->ship_zip,
                    'ship_email' => $request->ship_email,
                    'ship_company' => $request->ship_company,
                    'ship_phone' => $request->ship_phone,
                    'ship_address' => $request->ship_address,
                    'created_at' => Carbon::now(),
                ]);
            }
            return back();
        } elseif ($request->payment_method == 2) {
            echo 'ssl';
        } else {
            echo 'stripe';
        }
    }
}
