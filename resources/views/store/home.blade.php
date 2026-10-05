@extends('layouts.store')
@section('title','ShopVerse | Modern E-Commerce')
@section('content')
<section class="hero-original"><img src="{{ asset('storefront/img/slider/slider1.jpg') }}" alt="Summer collection"><div class="hero-copy container"><span>NEW COLLECTION</span><h1>Style that moves with you.</h1><p>Explore a database-driven storefront built from the original front-end design.</p><a class="btn btn-lg btn-primary" href="{{ route('shop') }}">Explore Shop</a></div></section>

<section class="section container"><div class="section-head"><div><span class="eyebrow">Collections</span><h2>Shop by category</h2></div><a href="{{ route('shop') }}">View all →</a></div>
<div class="category-grid">@foreach($categories as $category)<a class="category-card" href="{{ route('shop',['category'=>$category->slug]) }}"><div class="category-icon"><i class="bi bi-grid"></i></div><h3>{{ $category->name }}</h3><p>{{ $category->products_count }} products</p></a>@endforeach</div></section>

<section class="products section container"><div class="section-head"><div><span class="eyebrow">Handpicked</span><h2>Featured products</h2></div></div><div class="product-grid">@forelse($featured as $product) @include('partials.product-card') @empty <p>No featured products yet.</p> @endforelse</div></section>

<section class="campaign-strip"><div class="container"><div><span>PORTFOLIO BUILD</span><h2>Laravel 12 + transactional checkout + admin inventory</h2></div><a href="{{ route('shop') }}" class="btn btn-lg">Shop products</a></div></section>

<section class="products section container"><div class="section-head"><div><span class="eyebrow">New arrivals</span><h2>Latest products</h2></div></div><div class="product-grid">@foreach($latest as $product) @include('partials.product-card') @endforeach</div></section>
@endsection
