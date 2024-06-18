<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }
    public function products()
    {
        $products = Product::orderBy('name')->paginate(24);
        return view('dashboard.products', compact('products'));
    }
    public function categories()
    {
        $categories = Category::orderBy('name')->paginate(24);
        return view('dashboard.categories', compact('categories'));
    }

    public function orders()
    {
        $orders = Order::where('user_id', Auth::id())->get();
        return view('dashboard.orders', compact('orders'));
    }

    public function orders_all()
    {
        $orders = Order::paginate(24);
        return view('dashboard.orders-all', compact('orders'));
    }
}
