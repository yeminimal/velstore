<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\Store\ProductController;
use App\Http\Controllers\Store\CurrencyController;

Route::get('/', [StoreController::class, 'index'])->name('xylo.home');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::post('/change-currency', [CurrencyController::class, 'changeCurrency'])->name('change.currency');

