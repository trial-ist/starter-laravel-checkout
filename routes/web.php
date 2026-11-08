<?php

use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ShopController::class, 'index'])->name('shop');
Route::post('/orders', [ShopController::class, 'store'])->name('orders.store');
Route::get('/orders/{order}', [ShopController::class, 'show'])->name('orders.show');
