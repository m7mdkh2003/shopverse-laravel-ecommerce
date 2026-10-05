<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'products' => Product::count(),
            'orders' => Order::count(),
            'customers' => User::where('role', User::ROLE_USER)->count(),
            'revenue' => Order::whereIn('status', ['processing', 'shipped', 'completed'])->sum('total'),
            'low_stock' => Product::where('stock', '<=', 5)->count(),
            'messages' => ContactMessage::whereNull('read_at')->count(),
        ];
        $recentOrders = Order::with('user')->latest()->take(7)->get();
        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }
}
