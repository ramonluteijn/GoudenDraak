<?php

namespace App\Exports;

use App\Models\Order;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
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
        $qrCode = new Builder(
            writer: new PngWriter(),
            data: route('survey.index')
        );

        return Pdf::view('pdf.receipt', [
            'order' => $this->order,
            'qrCode' => $qrCode->build()->getDataUri(),
        ])
            ->paperSize(85, 100)
            ->name('receipt-order-' . $this->order->id . '.pdf')
            ->download();
    }
}
