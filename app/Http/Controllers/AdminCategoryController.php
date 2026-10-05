<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminCategoryController extends Controller
{
    public function index() { $categories = Category::withCount('products')->latest()->paginate(12); return view('admin.categories.index', compact('categories')); }
    public function create() { return view('admin.categories.form', ['category' => new Category]); }
    public function store(Request $request)
    {
        $data = $request->validate(['name' => ['required','string','max:120','unique:categories,name'], 'slug' => ['nullable','alpha_dash','max:140','unique:categories,slug'], 'description' => ['nullable','string','max:1000']]);
        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        Category::create($data);
        return redirect()->route('admin.categories.index')->with('success', 'Category created.');
    }
    public function edit(Category $category) { return view('admin.categories.form', compact('category')); }
    public function update(Request $request, Category $category)
    {
        $data = $request->validate(['name' => ['required','string','max:120',Rule::unique('categories','name')->ignore($category->id)], 'slug' => ['required','alpha_dash','max:140',Rule::unique('categories','slug')->ignore($category->id)], 'description' => ['nullable','string','max:1000']]);
        $category->update($data);
        return redirect()->route('admin.categories.index')->with('success', 'Category updated.');
    }
    public function destroy(Category $category)
    {
        if (Product::withTrashed()->where('category_id', $category->id)->exists()) return back()->withErrors(['category' => 'Move or remove products before deleting this category.']);
        $category->delete();
        return back()->with('success', 'Category deleted.');
    }
}
