<?php

namespace App\Http\Controllers;

use App\Models\customer;
use App\Models\EmailVerify;
use App\Notifications\CustomerEmailVerifyNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password as RulesPassword;
use Illuminate\Support\Facades\Notification;

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

        $customer_id = customer::insertGetId([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'created_at' => Carbon::now(),
        ]);
        $customer = customer::find($customer_id);
        EmailVerify::where('customer_id',$customer_id)->delete();
        $email_verify_info = EmailVerify::create([
            'customer_id'=> $customer_id,
            'token'=>uniqid(),
            'created_at'=>Carbon::now(),
        ]);
        Notification::send($customer, new CustomerEmailVerifyNotification($email_verify_info));
        return back()->with('success',"Resister success! A verification link sent to $request->email .Please verify login");
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
                if (Auth::guard('customer')->user()->email_verified_at == null) {
                    Auth::guard('customer')->logout();
                    return back()->with('not_verified','Please verify your email');
                }else{
                    return redirect()->route('index');
                }
            } else {
                return back()->with('exists','Wrong password');
            }
        } else {
            return back()->with('exists', 'Email does not exists');
        }
    }
    function customer_email_verify($token)  {
        $customer_id = EmailVerify::where('token',$token)->first()->customer_id;
        Customer::find($customer_id)->update([
            'email_verified_at'=>Carbon::now(),
        ]);
        EmailVerify::where('token',$token)->delete();
        return redirect()->route('customer.register')->with('verified',"Congratulation your email has been verified!");
    }
}
