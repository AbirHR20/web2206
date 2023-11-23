<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TagController extends Controller
{
    function tag() {
        $tages = Tag::all();
        return view('admin.tag.tag',[
            'tages'=>$tages,
        ]);
    }
    function tag_store(Request $request) {
        Tag::insert([
            'tag'=>$request->tag,
            'created_at'=>Carbon::now(),
        ]);
        return back();
    }
    function tag_remove($id) {
        Tag::find($id)->delete();
        return back();
    }
}
