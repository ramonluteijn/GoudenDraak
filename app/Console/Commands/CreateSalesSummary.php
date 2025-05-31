<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\SalesSummary;
use Illuminate\Console\Command;

class CreateSalesSummary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-sales-summary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new sales summary record';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creating a new sales summary record...');
        $salesSummary = new SalesSummary();

        $totalOrders = Order::where('created_at', '>=', now()->startOfDay())->count();
        if ($totalOrders === 0) {
            $this->error('No orders found for today.');
            return;
        }
        $totalSales = Order::where('created_at', '>=', now()->startOfDay())->sum('price');

        $salesSummary->total_sales = $totalSales;
        $salesSummary->total_orders = $totalOrders;
        $salesSummary->save();

        $productsSold = Order::where('created_at', '>=', now()->startOfDay())
            ->with('orderDetails.product')
            ->get()
            ->flatMap(function ($order) {
                return $order->orderDetails;
            })
            ->groupBy('product_id')
            ->map(function ($details) {
                return $details->sum('quantity');
            });

        foreach ($productsSold as $productId => $quantity) {
            $salesSummary->products()->attach($productId, ['quantity' => $quantity]);
        }

        $this->info('Sales summary record created successfully!');
    }
}
