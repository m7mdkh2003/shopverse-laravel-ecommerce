<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\CheckoutService;

class CustomerOrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->withCount('items')->latest()->paginate(10);
        return view('orders.mine', compact('orders'));
    }

    public function show(Order $order)
    {
        abort_unless($order->user_id === auth()->id() || auth()->user()->isAdmin(), 403);
        $order->load('items');
        return view('orders.show', compact('order'));
    }

    public function cancel(Order $order, CheckoutService $service)
    {
        abort_unless($order->user_id === auth()->id(), 403);
        $service->cancel($order);
        return back()->with('success', 'Order cancelled and stock restored.');
    }
}
