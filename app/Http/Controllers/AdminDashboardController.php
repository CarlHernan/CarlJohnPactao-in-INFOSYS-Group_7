<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function menus()
    {
        // Could add filtering/sorting later
        $products = Product::orderByDesc('created_at')->paginate(20);
        return view('admin.dashboard.menus', compact('products'));
    }

    public function orders()
    {
        // Placeholder - no Order model yet
        $orders = collect();
        return view('admin.dashboard.orders', compact('orders'));
    }
}

