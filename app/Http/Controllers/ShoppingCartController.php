<?php

namespace App\Http\Controllers;

class ShoppingCartController extends Controller
{
    public function index()
    {
        return view('shoppingcart.index');
    }

    public function confirmation()
    {
        session()->forget('order_id');
        return view('shoppingcart.confirmation');
    }
}
