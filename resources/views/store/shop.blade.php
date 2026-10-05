@extends('layouts.store')
@section('title','Shop | ShopVerse')
@section('content')
<section class="page-hero"><div class="container"><span class="eyebrow">Catalog</span><h1>Shop</h1><p>Search, filter and sort products stored in the database.</p></div></section>
<section class="section container">
<form class="shop-toolbar" method="GET">
    <input type="search" name="q" value="{{ request('q') }}" placeholder="Search products...">
    <select name="category"><option value="">All categories</option>@foreach($categories as $category)<option value="{{ $category->slug }}" @selected(request('category')===$category->slug)>{{ $category->name }}</option>@endforeach</select>
    <select name="sort"><option value="latest">Newest</option><option value="price_low" @selected(request('sort')==='price_low')>Price: low to high</option><option value="price_high" @selected(request('sort')==='price_high')>Price: high to low</option><option value="oldest" @selected(request('sort')==='oldest')>Oldest</option></select>
    <button class="btn btn-primary">Apply</button>
</form>
<div class="products"><div class="product-grid">@forelse($products as $product) @include('partials.product-card') @empty <div class="empty-state"><h3>No products found</h3><p>Try changing your filters.</p></div>@endforelse</div></div>
<div class="pagination-row">{{ $products->links('partials.pagination') }}</div>
</section>
@endsection
