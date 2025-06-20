<?php

namespace App\Http\Controllers;

class ShoppingCartController extends Controller
{
    public function index()
    {
        return view('shoppingcart.index');
    }
}
