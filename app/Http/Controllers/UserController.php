<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    function user_list() {
        $users = User::where('id','!=',Auth::id())->get();
        return view('admin.user.user_list', compact('users'));
    }
    function user_remove($user_id){
        User::find($user_id)->delete();
        return back()->with('delete','User Deleted Successfully!');
    }
}
