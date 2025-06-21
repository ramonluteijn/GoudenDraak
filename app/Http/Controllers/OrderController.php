<?php

namespace App\Http\Controllers;

use App\Exports\ReceiptExport;
use App\Models\Category;
use App\Services\OrderService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class OrderController
{
    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(): View
    {
        $categories = Category::with(['products.discounts' => function($query) {
            $query->where('start_date', '<=', now())
                  ->where('end_date', '>=', now());
        }])->get();

        foreach ($categories as $category) {
            foreach ($category->products as $product) {
                $activeDiscount = $product->discounts->sortByDesc('discount')->first();
                $product->original_price = $product->price;
                $product->discounted_price = $activeDiscount
                    ? round($product->price * (1 - $activeDiscount->discount / 100), 2)
                    : null;
            }
        }

        if (session('order_id')) {
            $this->orderService->loadOrder(session('order_id'));
        } else {
            $this->orderService->createEmptyOrder();
            session(['order_id' => $this->orderService->getOrder()->id]);
        }

        return view('shoppingcart.shop', [
            'order' => $this->orderService->getOrder(),
            'categories' => $categories,
        ]);
    }

    public function orderindex(): View
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

    public function createEmptyOrder(): RedirectResponse
    {
        $this->orderService->createEmptyOrder();
        session(['order_id' => $this->orderService->getOrder()->id]);
        return to_route('shop.index');
    }

    public function addToCart(int $productId): RedirectResponse
    {
        $orderId = session('order_id');
        if ($orderId) {
            $this->orderService->loadOrder($orderId);
            $this->orderService->addProductToOrder($productId);
        }
        return to_route('shop.index');
    }

    public function removeFromCart(int $productId): RedirectResponse
    {
        $orderId = session('order_id');
        if ($orderId) {
            $this->orderService->loadOrder($orderId);
            $this->orderService->removeProductFromOrder($productId);
        }
        return to_route('shop.index');
    }

    public function confirmationDownload(int $id)
    {
        return (new ReceiptExport($id))->confirmationDownload($id);
    }
}
