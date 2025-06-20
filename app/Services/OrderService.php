<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use RuntimeException;

class OrderService
{
    private ?Order $order = null;

    public function createEmptyOrder()
    {
        $orderId = Order::insertGetId([
            'user_id' => Auth::user()->id,
            'take_away' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $this->order = Order::find($orderId);
    }

    public function getOrder(): Order
    {
        $this->ensureOrderInitialized();
        return $this->order->load('products');
    }

    public function addProductToOrder($productId, $quantity = 1)
    {
        $this->ensureOrderInitialized();
        $existing = $this->order->products()->where('product_id', $productId)->first();

        $product = \App\Models\Product::with(['discounts' => function ($query) {
            $query->where('start_date', '<=', now())
                ->where('end_date', '>=', now());
        }])->find($productId);

        $activeDiscount = $product->discounts->sortByDesc('discount')->first();
        $unitPrice = $activeDiscount
            ? round($product->price * (1 - $activeDiscount->discount / 100), 2)
            : $product->price;

        if ($existing) {
            $this->updateProductQuantity($productId, $existing->pivot->quantity + $quantity);
            return;
        }

        $this->order->products()->attach($productId, [
            'quantity' => $quantity,
            'price' => $unitPrice,
        ]);
        $this->updateOrderPrice();
        $this->order->refresh();
    }

    public function removeProductFromOrder($productId)
    {
        $this->ensureOrderInitialized();
        $existing = $this->order->products()->where('product_id', $productId)->first();

        if ($existing) {
            $newQuantity = $existing->pivot->quantity - 1;
            if ($newQuantity <= 0) {
                $this->order->products()->detach($productId);
            } else {
                $price = $existing->pivot->price;
                if ($price === null) {
                    $product = \App\Models\Product::with(['discounts' => function ($query) {
                        $query->where('start_date', '<=', now())
                            ->where('end_date', '>=', now());
                    }])->find($productId);

                    $activeDiscount = $product->discounts->sortByDesc('discount')->first();
                    $price = $activeDiscount
                        ? round($product->price * (1 - $activeDiscount->discount / 100), 2)
                        : $product->price;
                }
                $this->order->products()->updateExistingPivot($productId, [
                    'quantity' => $newQuantity,
                    'price' => $price,
                ]);
            }
            $this->order->refresh();
        }
        $this->updateOrderPrice();
    }

    public function updateProductQuantity($productId, $quantity)
    {
        $this->ensureOrderInitialized();

        $product = \App\Models\Product::with(['discounts' => function ($query) {
            $query->where('start_date', '<=', now())
                ->where('end_date', '>=', now());
        }])->find($productId);

        $activeDiscount = $product->discounts->sortByDesc('discount')->first();
        $unitPrice = $activeDiscount
            ? round($product->price * (1 - $activeDiscount->discount / 100), 2)
            : $product->price;

        if ($quantity <= 0) {
            $this->order->products()->detach($productId);
        } else {
            $this->order->products()->updateExistingPivot($productId, [
                'quantity' => $quantity,
                'price' => $unitPrice,
            ]);
        }
        $this->updateOrderPrice();
        $this->order->refresh();
    }

    private function updateOrderPrice()
    {
        $this->ensureOrderInitialized();
        $totalPrice = $this->order->products->sum(function ($product) {
            return $product->price * $product->pivot->quantity;
        });
        $this->order->update(['price' => $totalPrice]);
    }

    private function ensureOrderInitialized()
    {
        if (!$this->order) {
            throw new RuntimeException('Order not initialized. Call createEmptyOrder() first.');
        }
    }

    public function loadOrder($orderId)
    {
        $this->order = Order::findOrFail($orderId);
    }
}
