<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CheckoutService
{
    public function checkout(User $user, array $data): Order
    {
        return DB::transaction(function () use ($user, $data) {
            $cart = $user->cartItems()->with('product')->lockForUpdate()->get();
            if ($cart->isEmpty()) {
                throw ValidationException::withMessages(['cart' => 'Your cart is empty.']);
            }

            $subtotal = 0;
            $lockedProducts = [];
            foreach ($cart as $item) {
                $product = Product::query()->lockForUpdate()->findOrFail($item->product_id);
                if (!$product->is_active || $product->stock < $item->quantity) {
                    throw ValidationException::withMessages([
                        'cart' => "{$product->name} no longer has enough stock for your requested quantity.",
                    ]);
                }
                $lockedProducts[$product->id] = $product;
                $subtotal += ((float) $product->price) * $item->quantity;
            }

            $shipping = $subtotal >= 200 ? 0 : 12;
            $order = $user->orders()->create([
                ...$data,
                'order_number' => 'ORD-'.now()->format('Ymd').'-'.strtoupper(bin2hex(random_bytes(3))),
                'status' => 'pending',
                'subtotal' => $subtotal,
                'shipping_amount' => $shipping,
                'total' => $subtotal + $shipping,
                'payment_method' => 'cash_on_delivery',
            ]);

            foreach ($cart as $item) {
                $product = $lockedProducts[$item->product_id];
                $lineTotal = ((float) $product->price) * $item->quantity;
                $order->items()->create([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'unit_price' => $product->price,
                    'quantity' => $item->quantity,
                    'line_total' => $lineTotal,
                ]);
                $product->decrement('stock', $item->quantity);
            }

            $user->cartItems()->delete();
            return $order->load('items');
        });
    }

    public function cancel(Order $order): void
    {
        DB::transaction(function () use ($order) {
            $order->load('items');
            if (!in_array($order->status, ['pending', 'processing'], true)) {
                throw ValidationException::withMessages(['order' => 'This order can no longer be cancelled.']);
            }
            foreach ($order->items as $item) {
                if ($item->product_id) {
                    Product::withTrashed()->whereKey($item->product_id)->lockForUpdate()->increment('stock', $item->quantity);
                }
            }
            $order->update(['status' => 'cancelled', 'cancelled_at' => now()]);
        });
    }
}
