<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{
    public function index()
    {
        $items = auth()->user()->cartItems()->with('product')->get();
        $subtotal = $items->sum(fn ($item) => ((float) $item->product->price) * $item->quantity);
        return view('cart.index', compact('items', 'subtotal'));
    }

    public function store(Request $request, Product $product)
    {
        $data = $request->validate(['quantity' => ['nullable', 'integer', 'min:1', 'max:20']]);
        $quantity = $data['quantity'] ?? 1;
        if (!$product->is_active || $product->stock < $quantity) {
            throw ValidationException::withMessages(['quantity' => 'Not enough stock is available.']);
        }
        $item = auth()->user()->cartItems()->firstOrNew(['product_id' => $product->id]);
        $item->quantity = min($product->stock, 20, ($item->exists ? $item->quantity : 0) + $quantity);
        $item->save();
        return back()->with('success', 'Product added to cart.');
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate(['quantity' => ['required', 'integer', 'min:1', 'max:20']]);
        $item = auth()->user()->cartItems()->where('product_id', $product->id)->firstOrFail();
        if ($data['quantity'] > $product->stock) {
            throw ValidationException::withMessages(['quantity' => 'Requested quantity exceeds current stock.']);
        }
        $item->update(['quantity' => $data['quantity']]);
        return back()->with('success', 'Cart updated.');
    }

    public function destroy(Product $product)
    {
        auth()->user()->cartItems()->where('product_id', $product->id)->delete();
        return back()->with('success', 'Item removed from cart.');
    }
}
