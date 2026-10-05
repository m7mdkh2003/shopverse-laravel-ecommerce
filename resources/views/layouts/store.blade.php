<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ShopVerse')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('storefront/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('storefront/css/portfolio.css') }}">
</head>
<body>
<header>
    <div class="global-notification"><div class="container"><p>FREE SHIPPING ON ORDERS OVER $200 — <a href="{{ route('shop') }}">SHOP NOW</a></p></div></div>
    <div class="header-row"><div class="container"><div class="header-wrapper">
        <div class="header-left"><a href="{{ route('home') }}" class="logo">SHOPVERSE</a></div>
        <div class="header-center"><nav class="navigation"><ul class="menu-list">
            <li><a href="{{ route('home') }}" class="menu-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
            <li><a href="{{ route('shop') }}" class="menu-link {{ request()->routeIs('shop','products.show') ? 'active' : '' }}">Shop</a></li>
            <li><a href="{{ route('contact') }}" class="menu-link {{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a></li>
            @auth @if(auth()->user()->isAdmin()) <li><a href="{{ route('admin.dashboard') }}" class="menu-link">Admin</a></li> @endif @endauth
        </ul></nav></div>
        <div class="header-right"><div class="header-right-links">
            @auth
                <a href="{{ route('orders.mine') }}" title="My orders"><i class="bi bi-person"></i></a>
                <a href="{{ route('wishlist.index') }}" title="Wishlist"><i class="bi bi-heart"></i></a>
                <a href="{{ route('cart.index') }}" class="header-cart-link" title="Cart"><i class="bi bi-bag"></i><span class="header-cart-count">{{ auth()->user()->cartItems()->sum('quantity') }}</span></a>
                <form action="{{ route('logout') }}" method="POST" class="inline-form">@csrf<button class="icon-button" title="Logout"><i class="bi bi-box-arrow-right"></i></button></form>
            @else
                <a href="{{ route('login') }}"><i class="bi bi-person"></i></a>
            @endauth
        </div></div>
    </div></div></div>
</header>

@if(session('success'))<div class="flash success container">{{ session('success') }}</div>@endif
@if($errors->any())<div class="flash error container"><strong>Please fix the following:</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

<main>@yield('content')</main>

<footer class="site-footer"><div class="container footer-grid">
    <div><a href="{{ route('home') }}" class="footer-logo">SHOPVERSE</a><p>A full-stack Laravel e-commerce portfolio project with inventory-safe checkout and role-based administration.</p></div>
    <div><h4>Shop</h4><a href="{{ route('shop') }}">All products</a><a href="{{ route('wishlist.index') }}">Wishlist</a><a href="{{ route('cart.index') }}">Cart</a></div>
    <div><h4>Account</h4>@auth<a href="{{ route('orders.mine') }}">My orders</a>@else<a href="{{ route('login') }}">Login</a><a href="{{ route('register') }}">Register</a>@endauth</div>
    <div><h4>Support</h4><a href="{{ route('contact') }}">Contact us</a><span>Cash on delivery demo checkout</span></div>
</div><div class="container footer-bottom">© {{ date('Y') }} ShopVerse. Portfolio project.</div></footer>
</body>
</html>
