<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;

/*
 * guys this page is for routing the web pages only, if you guys wanna
 * add api routes please go to api.php file
  */


//public usr pages
Route::get('/home', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/menu', [PageController::class, 'menu'])->name('menu');
Route::get('/orders', [PageController::class, 'orders'])->name('orders');

Route::get('/', function () { return redirect('/home'); });

// Admin dashboard main page
Route::prefix('admin')->middleware(['auth','verified'])->group(function () {
//    fix or fallback kung i type lang ng user kay /admin
    Route::get('/', function () { return redirect('admin/dashboard'); })->name('dashboard');

    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');

//    end points for menu dashboard
    Route::prefix('dashboard')->group(function () {
        Route::get('/menus', [ProductController::class, 'menus'])->name('admin.dashboard.menus');
        Route::get('/menus/create', [ProductController::class, 'create'])->name('admin.dashboard.menus.create');
        Route::post('/menus', [ProductController::class, 'store'])->name('admin.dashboard.menus.store');
        Route::get('/menus/{product}/edit', [ProductController::class, 'edit'])->name('admin.dashboard.menus.edit');
        Route::put('/menus/{product}', [ProductController::class, 'update'])->name('admin.dashboard.menus.update');
        Route::delete('/menus/{product}', [ProductController::class, 'destroy'])->name('admin.dashboard.menus.destroy');
        
        // Order management routes
        Route::get('/orders', [OrderController::class, 'index'])->name('admin.dashboard.orders');
        Route::get('/orders/stats', [OrderController::class, 'getStats'])->name('admin.dashboard.orders.stats');
        Route::get('/orders/search', [OrderController::class, 'search'])->name('admin.dashboard.orders.search');
        Route::get('/orders/status/{status}', [OrderController::class, 'getByStatus'])->name('admin.dashboard.orders.by-status');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('admin.dashboard.orders.show');
        Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.dashboard.orders.status');
        Route::put('/orders/{order}/delivery', [OrderController::class, 'updateDeliveryStatus'])->name('admin.dashboard.orders.delivery');
        Route::put('/orders/{order}/payment', [OrderController::class, 'updatePaymentStatus'])->name('admin.dashboard.orders.payment');
        
        // Category management routes
        Route::get('/categories', [CategoryController::class, 'index'])->name('admin.dashboard.categories');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('admin.dashboard.categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])->name('admin.dashboard.categories.store');
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('admin.dashboard.categories.edit');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('admin.dashboard.categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('admin.dashboard.categories.destroy');
    });

//    profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
