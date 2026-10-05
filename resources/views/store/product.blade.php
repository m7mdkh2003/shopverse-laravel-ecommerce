@extends('layouts.store')
@section('title',$product->name.' | ShopVerse')
@section('content')
<section class="section container product-detail">
    <div><div class="product-gallery"><img src="{{ asset($product->image ?: 'storefront/img/products/product1/1.png') }}" alt="{{ $product->name }}"></div>@if($product->gallery)<div class="product-thumbs">@foreach($product->gallery as $image)<img src="{{ asset($image) }}" alt="{{ $product->name }}">@endforeach</div>@endif</div>
    <div class="product-summary"><span class="eyebrow">{{ $product->category->name }}</span><h1>{{ $product->name }}</h1>
        <div class="detail-price"><strong>${{ number_format((float)$product->price,2) }}</strong>@if($product->compare_at_price)<span>${{ number_format((float)$product->compare_at_price,2) }}</span>@endif</div>
        <p>{{ $product->description }}</p><div class="stock {{ $product->stock <= 5 ? 'low' : '' }}">{{ $product->stock > 0 ? $product->stock.' in stock' : 'Out of stock' }}</div>
        @auth<div class="buy-row"><form action="{{ route('cart.store',$product) }}" method="POST">@csrf<div class="qty-control"><input type="number" name="quantity" min="1" max="{{ max(1,$product->stock) }}" value="1"><button class="btn btn-lg btn-primary" {{ $product->stock < 1 ? 'disabled' : '' }}>Add to cart</button></div></form><form action="{{ route('wishlist.toggle',$product) }}" method="POST">@csrf<button class="btn btn-lg">♡ Wishlist</button></form></div>@else<a class="btn btn-lg btn-primary" href="{{ route('login') }}">Login to purchase</a>@endauth
        <div class="trust-grid"><div><i class="bi bi-shield-check"></i><b>Inventory safe</b><span>Stock locked during checkout</span></div><div><i class="bi bi-truck"></i><b>Free over $200</b><span>Shipping calculated automatically</span></div></div>
    </div>
</section>
@if($related->isNotEmpty())<section class="products section container"><div class="section-head"><h2>You may also like</h2></div><div class="product-grid">@foreach($related as $product) @include('partials.product-card') @endforeach</div></section>@endif
@endsection
