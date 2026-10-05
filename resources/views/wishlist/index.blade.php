@extends('layouts.store')
@section('title','Wishlist | ShopVerse')
@section('content')
<section class="page-hero"><div class="container"><span class="eyebrow">Saved</span><h1>Wishlist</h1></div></section><section class="products section container"><div class="product-grid">@forelse($products as $product) @include('partials.product-card') @empty<div class="empty-state"><h2>No saved products yet</h2><a href="{{ route('shop') }}" class="btn btn-primary">Browse products</a></div>@endforelse</div>{{ $products->links('partials.pagination') }}</section>
@endsection
