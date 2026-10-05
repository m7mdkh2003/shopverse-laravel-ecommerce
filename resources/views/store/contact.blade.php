@extends('layouts.store')
@section('title','Contact | ShopVerse')
@section('content')
<section class="page-hero"><div class="container"><span class="eyebrow">Support</span><h1>Contact us</h1><p>Messages are persisted to the admin database.</p></div></section>
<section class="section container narrow"><form class="panel form-grid" method="POST" action="{{ route('contact.store') }}">@csrf<label>Name<input name="name" value="{{ old('name') }}" required></label><label>Email<input type="email" name="email" value="{{ old('email') }}" required></label><label class="span-2">Subject<input name="subject" value="{{ old('subject') }}" required></label><label class="span-2">Message<textarea name="message" rows="7" required>{{ old('message') }}</textarea></label><button class="btn btn-primary span-2">Send message</button></form></section>
@endsection
