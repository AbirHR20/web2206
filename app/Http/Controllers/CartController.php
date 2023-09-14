<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    function cart_store(Request $request) {
        print_r($request->all());
    }
}
