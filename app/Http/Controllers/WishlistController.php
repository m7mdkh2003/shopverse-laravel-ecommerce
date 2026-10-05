<?php

namespace App\Http\Controllers;

use App\Models\Product;

class WishlistController extends Controller
{
    public function index()
    {
        $products = auth()->user()->wishlist()->with('category')->latest('product_user.created_at')->paginate(12);
        return view('wishlist.index', compact('products'));
    }

    public function toggle(Product $product)
    {
        auth()->user()->wishlist()->toggle($product->id);
        return back()->with('success', 'Wishlist updated.');
    }
}
