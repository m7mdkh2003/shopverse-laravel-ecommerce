<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Category;
use App\Models\Product;

class AdminProductController extends Controller
{
    public function index() { $products = Product::with('category')->latest()->paginate(15); return view('admin.products.index', compact('products')); }
    public function create() { return view('admin.products.form', ['product' => new Product, 'categories' => Category::orderBy('name')->get()]); }
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active');
        Product::create($data);
        return redirect()->route('admin.products.index')->with('success', 'Product created.');
    }
    public function edit(Product $product) { return view('admin.products.form', ['product' => $product, 'categories' => Category::orderBy('name')->get()]); }
    public function update(StoreProductRequest $request, Product $product)
    {
        $data = $request->validated();
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active');
        $product->update($data);
        if (! $product->is_active) {
            $product->cartItems()->delete();
        }
        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    }
    public function destroy(Product $product) { $product->cartItems()->delete(); $product->delete(); return back()->with('success', 'Product archived.'); }
    public function archive() { $products = Product::onlyTrashed()->with('category')->latest('deleted_at')->paginate(15); return view('admin.products.archive', compact('products')); }
    public function restore(int $product) { Product::onlyTrashed()->findOrFail($product)->restore(); return back()->with('success', 'Product restored.'); }
}
