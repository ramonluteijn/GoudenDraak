<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Auth::user()->orders()->with('orderDetails')->get();
        return view('orders.index', [
            'orders' => $orders,
        ]);
    }

    public function show(int $id): View
    {
        $order = Auth::user()->orders()->with('orderDetails')->with('orderDetails.product')->findOrFail($id);
        return view('orders.show', [
            'order' => $order,
        ]);
    }
}
