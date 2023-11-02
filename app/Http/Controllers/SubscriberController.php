<?php

namespace App\Http\Controllers;

use App\Mail\Newsletter;
use App\Models\Subscriber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SubscriberController extends Controller
{
    function subscriber_store(Request $request) {
        Subscriber::insert([
            'email'=>$request->email,
            'created_at'=> Carbon::now(),
        ]);
        return redirect()->route('index', '#subs')->with('subs',"Subscribe success!");
    }
    function subscriber() {
        $subscribers = Subscriber::all();
        return view('admin.subscribe.subscriber',[
            'subscribers'=>$subscribers,
        ]);
    }
    function send_newsletter($id) {
        $sub = Subscriber::find($id);       
        Mail::to($sub->email)->send(new Newsletter($sub));
        return back()->with('success',"Newsletter successfully send to $sub->email");
    }
}
