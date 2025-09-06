<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;

//public usr pages
Route::get('/home', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/menu', [PageController::class, 'menu'])->name('menu');
Route::get('/orders', [PageController::class, 'orders'])->name('orders');

Route::get('/', function () { return redirect('/home'); });

// Admin dashboard main page
Route::prefix('admin')->middleware(['auth','verified'])->group(function () {
    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');

//    end points
    Route::prefix('dashboard')->group(function () {
        Route::get('/menus', [ProductController::class, 'menus'])->name('admin.dashboard.menus');
        Route::get('/menus/create', [ProductController::class, 'create'])->name('admin.dashboard.menus.create');
        Route::post('/menus', [ProductController::class, 'store'])->name('admin.dashboard.menus.store');
        Route::get('/menus/{product}/edit', [ProductController::class, 'edit'])->name('admin.dashboard.menus.edit');
        Route::put('/menus/{product}', [ProductController::class, 'update'])->name('admin.dashboard.menus.update');
        Route::delete('/menus/{product}', [ProductController::class, 'destroy'])->name('admin.dashboard.menus.destroy');
        Route::get('/orders', [ProductController::class, 'orders'])->name('admin.dashboard.orders');
    });

//    profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
