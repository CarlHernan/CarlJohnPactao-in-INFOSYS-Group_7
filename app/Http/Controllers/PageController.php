<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;


//Page controller v1 -perez
class PageController extends Controller
{
    public function home()
    {
        $featured = Product::where('is_featured', true)->take(3)->get();
        return view('home', compact('featured'));
    }

    public function about()
    {
        return view('about');
    }

    public function menu()
    {
        $menu = Product::all();
        return view('menu', compact('menu'));
    }

    public function orders()
    {
        return view('orders');
    }
}
