<?php

namespace App\Http\Controllers;

use App\Models\customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password as RulesPassword;

class CustomerAuthController extends Controller
{
    function customer_login()
    {
        return view('frontend.customer.login');
    }
    function customer_register()
    {
        return view('frontend.customer.register');
    }
    function customer_store(Request $request)
    {
        $request->validate([
            'fname' => 'required',
            'email' => 'required',
            'password' => RulesPassword::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols(),
            'password_confirmation' => 'required',
        ]);

        customer::insert([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'created_at' => Carbon::now(),
        ]);
        return back()->with('success', 'Customer register successfully!');
    }
    function customer_login_confirm(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        if (customer::where('email', $request->email)->exists()) {
            if (Auth::guard('customer')->attempt([
                'email' => $request->email,
                'password' => $request->password,
            ])) {
                return redirect()->route('index');
            } else {
                return back()->with('exists','Wrong password');
            }
        } else {
            return back()->with('exists', 'Email does not exists');
        }
    }
}
