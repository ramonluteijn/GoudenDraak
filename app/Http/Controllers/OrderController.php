<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Services\OrderService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(): View
    {
        $products = Product::all();
        $categories = Category::all();
        if (session('order_id')) {
            $this->orderService->loadOrder(session('order_id'));
        } else {
            $this->orderService->createEmptyOrder();
            session(['order_id' => $this->orderService->getOrder()->id]);
        }

        return view('orders.shop', [
            'order' => $this->orderService->getOrder(),
            'products' => $products,
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

    public function createEmptyOrder(): \Illuminate\Http\RedirectResponse
    {
        $this->orderService->createEmptyOrder();
        session(['order_id' => $this->orderService->getOrder()->id]);
        return to_route('shop.index');
    }

    public function addToCart(int $productId): \Illuminate\Http\RedirectResponse
    {
        $orderId = session('order_id');
        if ($orderId) {
            $this->orderService->loadOrder($orderId);
            $this->orderService->addProductToOrder($productId);
        }
        return to_route('shop.index');
    }

    public function removeFromCart(int $productId): \Illuminate\Http\RedirectResponse
    {
        $orderId = session('order_id');
        if ($orderId) {
            $this->orderService->loadOrder($orderId);
            $this->orderService->removeProductFromOrder($productId);
        }
        return to_route('shop.index');
    }

    public function destroySession(){
        session()->forget('order_id');
        return redirect()->back()->with('status', 'Winkelwagen geleegd.');
    }
}
