<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\CheckoutService;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user')->withCount('items')->latest();
        if ($request->filled('status')) $query->where('status', $request->status);
        $orders = $query->paginate(15)->withQueryString();
        return view('admin.orders.index', compact('orders'));
    }
    public function update(Request $request, Order $order, CheckoutService $service)
    {
        $data = $request->validate(['status' => ['required', 'in:'.implode(',', Order::STATUSES)]]);
        if ($data['status'] === $order->status) {
            return back();
        }
        if (! $order->canTransitionTo($data['status'])) {
            return back()->withErrors(['status' => "Cannot move an order from {$order->status} to {$data['status']}."]);
        }
        if ($data['status'] === 'cancelled') {
            $service->cancel($order);
        } else {
            $order->update(['status' => $data['status']]);
        }
        return back()->with('success', 'Order status updated.');
    }
}
