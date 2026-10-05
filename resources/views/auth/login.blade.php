@extends('layouts.store')
@section('title','Login | ShopVerse')
@section('content')<section class="auth-shell"><form class="panel auth-card" method="POST" action="{{ route('login.store') }}">@csrf<span class="eyebrow">Welcome back</span><h1>Login</h1><label>Email<input type="email" name="email" value="{{ old('email') }}" required autofocus></label><label>Password<input type="password" name="password" required></label><button class="btn btn-lg btn-primary">Login</button><p>New here? <a href="{{ route('register') }}">Create an account</a></p></form></section>@endsection
