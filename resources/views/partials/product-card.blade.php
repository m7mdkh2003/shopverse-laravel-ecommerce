<article class="product-item">
    <div class="product-image">
        <a href="{{ route('products.show', $product) }}"><img src="{{ asset($product->image ?: 'storefront/img/products/product1/1.png') }}" alt="{{ $product->name }}" class="img1"></a>
    </div>
    <div class="product-info">
        <div class="eyebrow">{{ $product->category->name ?? 'Collection' }}</div>
        <a href="{{ route('products.show', $product) }}" class="product-title">{{ $product->name }}</a>
        <div class="product-prices"><strong class="new-price">${{ number_format((float)$product->price, 2) }}</strong>@if($product->compare_at_price)<span class="old-price">${{ number_format((float)$product->compare_at_price, 2) }}</span>@endif</div>
        <div class="card-actions">
            @auth
            <form method="POST" action="{{ route('cart.store', $product) }}">@csrf<button class="btn btn-sm btn-primary" {{ $product->stock < 1 ? 'disabled' : '' }}><i class="bi bi-bag-plus"></i> Add</button></form>
            <form method="POST" action="{{ route('wishlist.toggle', $product) }}">@csrf<button class="btn-icon" title="Wishlist"><i class="bi bi-heart"></i></button></form>
            @else
            <a href="{{ route('login') }}" class="btn btn-sm btn-primary">Login to buy</a>
            @endauth
        </div>
    </div>
    @if($product->compare_at_price && $product->compare_at_price > $product->price)<span class="product-discount">SALE</span>@endif
</article>
