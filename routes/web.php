<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DashboardController;

/*
 * guys this page is for routing the web pages only, if you guys wanna
 * add api routes please go to api.php file
  */


// Root: require login first, then send to home
Route::get('/', function () {
    return Auth::guard('web')->check()
        ? redirect('/home')
        : redirect('/login');
});

// public user pages
Route::get('/home', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/menu', [PageController::class, 'menu'])->name('menu');
// Product detail page (must be after the /menu listing route)
Route::get('/menu/{product}', [ProductController::class, 'showPage'])->name('menu.show');
Route::get('/orders', [PageController::class, 'orders'])->name('orders');

// Public user profile management (web guard)
Route::middleware('auth:web')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('user.profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('user.profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('user.profile.destroy');
});

// Admin dashboard main page
Route::prefix('admin')->middleware('auth:admin')->group(function () {
//    fix or fallback kung i type lang ng user kay /admin
    Route::get('/', function () { return redirect('admin/dashboard'); })->name('dashboard');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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
        Route::put('/orders/{order}/payment', [PaymentController::class, 'updatePaymentStatus'])->name('admin.dashboard.orders.payment');

        // Payment management routes
        Route::get('/payments', [PaymentController::class, 'index'])->name('admin.dashboard.payments');
        Route::get('/payments/stats', [PaymentController::class, 'getStats'])->name('admin.dashboard.payments.stats');
        Route::get('/payments/status/{status}', [PaymentController::class, 'getByStatus'])->name('admin.dashboard.payments.by-status');
        Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('admin.dashboard.payments.show');
        Route::put('/payments/{payment}/status', [PaymentController::class, 'updateStatus'])->name('admin.dashboard.payments.status');
        Route::put('/payments/{payment}/update', [PaymentController::class, 'updateWithProof'])->name('admin.dashboard.payments.update');
        Route::get('/payments/{payment}/download-proof', [PaymentController::class, 'downloadProof'])->name('admin.dashboard.payments.download-proof');

        // Category management routes
        Route::get('/categories', [CategoryController::class, 'index'])->name('admin.dashboard.categories');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('admin.dashboard.categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])->name('admin.dashboard.categories.store');
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('admin.dashboard.categories.edit');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('admin.dashboard.categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('admin.dashboard.categories.destroy');

        // Customer management routes
        Route::get('/customers', [CustomerController::class, 'index'])->name('admin.dashboard.customers');
        Route::get('/customers/stats', [CustomerController::class, 'stats'])->name('admin.dashboard.customers.stats');
        Route::get('/customers/search', [CustomerController::class, 'search'])->name('admin.dashboard.customers.search');
        Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('admin.dashboard.customers.show');
        Route::put('/customers/{customer}/toggle-status', [CustomerController::class, 'toggleStatus'])->name('admin.dashboard.customers.toggle-status');
        Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('admin.dashboard.customers.destroy');

        // Reports & Analytics routes
        Route::get('/reports/sales', [ReportsController::class, 'sales'])->name('admin.dashboard.reports.sales');
        Route::get('/reports/products', [ReportsController::class, 'products'])->name('admin.dashboard.reports.products');
        Route::get('/reports/customers', [ReportsController::class, 'customers'])->name('admin.dashboard.reports.customers');
        Route::get('/reports/sales/export', [ReportsController::class, 'exportSales'])->name('admin.dashboard.reports.sales.export');
    });

//    profile management (admin)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
