<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Services\CheckoutService;

class CheckoutController extends Controller
{
    public function create()
    {
        $items = auth()->user()->cartItems()->with('product')->get();
        abort_if($items->isEmpty(), 404);
        $subtotal = $items->sum(fn ($item) => ((float) $item->product->price) * $item->quantity);
        return view('checkout.create', compact('items', 'subtotal'));
    }

    public function store(CheckoutRequest $request, CheckoutService $service)
    {
        $order = $service->checkout($request->user(), $request->validated());
        return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully.');
    }
}
