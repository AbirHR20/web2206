<?php

namespace App\Http\Controllers;

use App\Models\customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class CustomerController extends Controller
{
    function customer_profile()
    {
        return view('frontend.customer.profile');
    }
    function customer_logout()
    {
        Auth::guard('customer')->logout();
        return redirect('/');
    }
    function customer_profile_update(Request $request)
    {
        if ($request->password == '') {
            if ($request->image == '') {
                customer::find(Auth::guard('customer')->id())->update([
                    'fname' => $request->fname,
                    'lname' => $request->lname,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'zip' => $request->zip,
                    'country' => $request->country,
                    'address' => $request->address,
                ]);
                return back()->with('success', 'profile updated!');
            } else {
                if (Auth::guard('customer')->user()->photo != null) {
                    $delete = public_path('uploads/customer/' . Auth::guard('customer')->user()->photo);
                    unlink($delete);
                }
                $img = $request->image;
                $extension = $img->extension();
                $file_name = Auth::guard('customer')->id() . '.' . $extension;
                Image::make($img)->save(public_path('uploads/customer/' . $file_name));
                customer::find(Auth::guard('customer')->id())->update([
                    'fname' => $request->fname,
                    'lname' => $request->lname,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'zip' => $request->zip,
                    'country' => $request->country,
                    'address' => $request->address,
                    'photo' => $file_name,
                    'updated_at' => Carbon::now(),
                ]);
                return back()->with('success', 'profile updated!');
            }
        } else {
            if ($request->image == '') {
                customer::find(Auth::guard('customer')->id())->update([
                    'fname' => $request->fname,
                    'lname' => $request->lname,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'phone' => $request->phone,
                    'zip' => $request->zip,
                    'country' => $request->country,
                    'address' => $request->address,
                ]);
                return back()->with('success', 'profile updated!');
            } else {
                if (Auth::guard('customer')->user()->photo != null) {
                    $delete = public_path('uploads/customer/' . Auth::guard('customer')->user()->photo);
                    unlink($delete);
                }
                $img = $request->image;
                $extension = $img->extension();
                $file_name = Auth::guard('customer')->id() . '.' . $extension;
                Image::make($img)->save(public_path('uploads/customer/' . $file_name));
                customer::find(Auth::guard('customer')->id())->update([
                    'fname' => $request->fname,
                    'lname' => $request->lname,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'phone' => $request->phone,
                    'zip' => $request->zip,
                    'country' => $request->country,
                    'address' => $request->address,
                    'photo' => $file_name,
                    'updated_at' => Carbon::now(),
                ]);
                return back()->with('success', 'profile updated!');
            }
        }
    }
}
