<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;


//Page controller v1 -perez
class PageController extends Controller
{
    public function home()
    {
        $featuredProducts = Product::where('is_featured', true)->take(3)->get();
        $product = Product::all();
        return view('home', compact('featuredProducts', 'product'));
    }

    public function about()
    {
        return view('about');
    }

    public function menu()
    {
        $products = Product::all();
        return view('menu', compact('products'));
    }

    public function orders()
    {
        return view('orders');
    }
}
