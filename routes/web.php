<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

// Welcome page
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->isSeller()
            ? redirect()->route('seller.dashboard')
            : redirect()->route('buyer.dashboard');
    }
    return view('welcome');
});

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Buyer routes
Route::middleware(['auth', 'role:buyer'])->prefix('buyer')->name('buyer.')->group(function () {
    Route::get('/dashboard', [BuyerController::class, 'dashboard'])->name('dashboard');
    Route::get('/services', [BuyerController::class, 'services'])->name('services');
    Route::get('/services/{service}', [BuyerController::class, 'serviceDetail'])->name('services.show');
    Route::get('/orders', [OrderController::class, 'buyerIndex'])->name('orders');
    Route::get('/orders/{order}', [OrderController::class, 'buyerShow'])->name('orders.show');
    Route::get('/order/create/{service}', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/order/store', [OrderController::class, 'store'])->name('orders.store');
    Route::post('/orders/{order}/upload-proof', [OrderController::class, 'uploadProof'])->name('orders.upload-proof');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
});

// Seller routes
Route::middleware(['auth', 'role:seller'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', [SellerController::class, 'dashboard'])->name('dashboard');

    // Services CRUD
    Route::get('/services', [ServiceController::class, 'index'])->name('services');
    Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
    Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
    Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');
    Route::patch('/services/{service}/toggle', [ServiceController::class, 'toggleActive'])->name('services.toggle');

    // Orders management
    Route::get('/orders', [OrderController::class, 'sellerIndex'])->name('orders');
    Route::get('/orders/report', [OrderController::class, 'report'])->name('orders.report');
    Route::get('/orders/{order}', [OrderController::class, 'sellerShow'])->name('orders.show');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::delete('/orders/{order}/force', [OrderController::class, 'forceDelete'])->name('orders.force-delete');
});
