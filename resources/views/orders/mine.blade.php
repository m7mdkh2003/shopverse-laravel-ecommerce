@extends('layouts.store')
@section('title','My Orders | ShopVerse')
@section('content')
<section class="page-hero"><div class="container"><span class="eyebrow">Account</span><h1>My orders</h1></div></section><section class="section container"><div class="panel table-wrap"><table class="data-table"><thead><tr><th>Order</th><th>Date</th><th>Items</th><th>Status</th><th>Total</th><th></th></tr></thead><tbody>@forelse($orders as $order)<tr><td>{{ $order->order_number }}</td><td>{{ $order->created_at->format('M d, Y') }}</td><td>{{ $order->items_count }}</td><td><span class="badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td><td>${{ number_format((float)$order->total,2) }}</td><td><a href="{{ route('orders.show',$order) }}">View</a></td></tr>@empty<tr><td colspan="6">No orders yet.</td></tr>@endforelse</tbody></table></div>{{ $orders->links('partials.pagination') }}</section>
@endsection
