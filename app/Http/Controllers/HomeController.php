<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Intervention\Image\Facades\Image;

class HomeController extends Controller
{
    function dashboard(){
        return view('dashboard');
    }
    function user_profile(){
        return view('admin.user.user');
    }
    function user_info_update(Request $request) {
        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'email' => 'email:rfc,dns',
        ]);
        User::find(Auth::id())->update([
            'name'=> $request->name,
            'email'=> $request->email,
        ]);
        return back();
    }
    function password_update(Request $request){
        $request->validate([
            'current_password'=>'required',
            'password'=>'required|confirmed',
            'password'=> Password::min(8)
            ->letters()
            ->mixedCase()
            ->numbers()
            ->symbols(),
            'password_confirmation'=>'required',
        ]);
        $user = User::find(Auth::id());
        if (password_verify($request->current_password,$user->password)) {
            User::find(Auth::id())->update([
                'password'=>bcrypt($request->password),
            ]);
            return back()->with('pass_update','Password updated successfully!');
        }else {
            return back()->with('current_pass','wrong current password');
        }
    }
    function user_photo_update(Request $request){
        $request->validate([
            'photo'=>'required|mimes:png,jpg|file|max:512|dimensions:min_width=200,min_height=300',
        ]);
        if (Auth::user()->photo==null) {
            $photo = $request->photo;
            $extension = $photo->extension();
            $file_name = Auth::id() . '.' . $extension;
            $image = Image::make($photo)->resize(300, 200)->save(public_path('uploads/user/' . $file_name));
            User::find(Auth::id())->update([
                'photo' => $file_name,
            ]);
            return back()->with('photo_update', 'Profile photo updated successfully!');
        } else {
            $present_photo = public_path('uploads/user/'.Auth::user()->photo);
            unlink($present_photo);
            $photo = $request->photo;
            $extension = $photo->extension();
            $file_name = Auth::id() . '.' . $extension;
            $image = Image::make($photo)->resize(300, 200)->save(public_path('uploads/user/' . $file_name));
            User::find(Auth::id())->update([
                'photo' => $file_name,
            ]);
            return back()->with('photo_update', 'Profile photo updated successfully!');
        }
    }
}
