<?php

namespace App\Http\Controllers;

use App\Models\customer;
use App\Models\PasswordReset;
use App\Notifications\PasswordResetNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rules\Password;
use Stripe\Customer as StripeCustomer;

class PasswordResetController extends Controller
{
    function password_reset()  {
        return view('frontend.customer.password_reset_req');
    }
    function passwordreset_request_sent(Request $request) {
        if (customer::where('email',$request->email)->exists()) {
            $customer = customer::where('email',$request->email)->first();
            PasswordReset::where('customer_id',$customer->id)->delete();
            $reset_info = PasswordReset::create([
                'customer_id'=>$customer->id,
                'token'=>uniqid(),
                'created_at'=>Carbon::now(),
            ]);
            Notification::send($customer, new PasswordResetNotification($reset_info));
            return back()->with('success',"Password reset request sent to $request->email");
        }else {
            return back()->with('dont_exists',"Email dosen't exists!");
        }
    }
    function passwordreset_form($token) {
        return view('frontend.customer.password_reset_form',[
            'token'=>$token,
        ]);
    }
    function password_reset_confirm(Request $request, $token) {
        $customer_id = PasswordReset::where('token',$token)->first();
        $request->validate([
            'password' => Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols(),
            'password_confirmation' => 'required',
        ]);
        if ($customer_id != '') {
            customer::find($customer_id->customer_id)->update([
                'password'=>bcrypt($request->password),
                'created_at'=>Carbon::now(),
            ]);
        } else {
            return back()->with('reset_already',"Password reset already!");
        }
        
        
        PasswordReset::where('token',$token)->delete();
        return back()->with('success',"Password reset successfull!");
    }
}
