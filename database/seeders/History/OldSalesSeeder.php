<?php

namespace Database\Seeders\History;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class OldSalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $oldSales = DB::table('OldSales')->get();
        $oldProducts = DB::table('OldProducts')->get();

        $salesByDate = $oldSales->groupBy(function ($sale) {
            return \Carbon\Carbon::parse($sale->saleDate)->toDateString();
        });

        foreach ($salesByDate as $date => $sales) {
            $orderId = DB::table('orders')->insertGetId([
                'created_at' => $date,
                'updated_at' => now(),
            ]);

            foreach ($sales as $sale) {
                $product = $oldProducts->where('id', $sale->itemId)->first();
                if ($product) {
                    DB::table('order_details')->insert([
                        'order_id'   => $orderId,
                        'product_id' => $product->id,
                        'quantity'   => $sale->amount,
                        'created_at' => $sale->saleDate,
                        'updated_at' => now(),
                    ]);
                }
            }

            DB::table('orders')
                ->where('id', $orderId)
                ->update([
                    'price' => $sales->sum(function ($sale) use ($oldProducts) {
                        $product = $oldProducts->where('id', $sale->itemId)->first();
                        return $product ? $product->price * $sale->amount : 0;
                    }),
                ]);

            DB::table('sales_summaries')->insert([
                'total_sales' => $sales->sum(function ($sale) use ($oldProducts) {
                    $product = $oldProducts->where('id', $sale->itemId)->first();
                    return $product ? $product->price * $sale->amount : 0;
                }),
                'total_orders' => $sales->count(),
                'created_at' => $date,
                'updated_at' => now(),
            ]);
        }
    }
}
