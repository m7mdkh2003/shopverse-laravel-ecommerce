<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class StorefrontController extends Controller
{
    public function home()
    {
        $featured = Product::visible()->with('category')->where('is_featured', true)->latest()->take(8)->get();
        $latest = Product::visible()->with('category')->latest()->take(8)->get();
        $categories = Category::withCount(['products' => fn ($q) => $q->visible()])->take(6)->get();
        return view('store.home', compact('featured', 'latest', 'categories'));
    }

    public function shop(Request $request)
    {
        $query = Product::visible()->with('category');
        if ($request->filled('q')) {
            $term = trim((string) $request->q);
            $query->where(fn ($q) => $q->where('name', 'like', "%{$term}%")->orWhere('description', 'like', "%{$term}%"));
        }
        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->category));
        }
        match ($request->get('sort')) {
            'price_low' => $query->orderBy('price'),
            'price_high' => $query->orderByDesc('price'),
            'oldest' => $query->oldest(),
            default => $query->latest(),
        };
        $products = $query->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();
        return view('store.shop', compact('products', 'categories'));
    }

    public function product(Product $product)
    {
        abort_unless($product->is_active, 404);
        $product->load('category');
        $related = Product::visible()->where('category_id', $product->category_id)->where('id', '!=', $product->id)->take(4)->get();
        return view('store.product', compact('product', 'related'));
    }
}
