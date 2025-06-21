<?php

namespace App\Http\Controllers;

use App\Exports\ReceiptExport;

class ShoppingCartController extends Controller
{
    public function index()
    {
        return view('shoppingcart.index');
    }

    public function confirmation()
    {
        $qrcode = (new ReceiptExport(session()->get('order_id')))->confirmation();
        $orderId = session()->get('order_id');
        session()->forget('order_id');

        return view('shoppingcart.confirmation', [
            'qrcode' => $qrcode,
            'orderId' => $orderId,
        ]);
    }
}
