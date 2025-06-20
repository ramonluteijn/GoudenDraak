<?php

namespace App\Exports;

use App\Models\Order;
use Spatie\LaravelPdf\Facades\Pdf;

class ReceiptExport
{
    protected $order;

    public function __construct($orderId)
    {
        $this->order = Order::with(['orderDetails.product', 'table'])->findOrFail($orderId);
    }

    public function download()
    {
        return Pdf::view('pdf.receipt', [
            'order' => $this->order,
        ])
            ->paperSize(85, 100)
            ->name('receipt-order-' . $this->order->id . '.pdf')
            ->download();
    }
}
