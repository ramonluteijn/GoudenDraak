<?php

namespace App\Exports;

use App\Models\Product;
use App\Models\Discount;

use Spatie\LaravelPdf\Facades\Pdf;

class ProductExport
{
    public function download()
    {
        $products = Product::with('category')->get()->groupBy('category.name');
        $discounts = Discount::where('active', true)->with('product')->orderBy('product_id', 'asc')->get();

        return Pdf::view('pdf.products', [
            'products' => $products,
            'discounts' => $discounts,
        ])
            ->paperSize(210, 297)
            ->name('products-list.pdf')
            ->download();
    }
}
