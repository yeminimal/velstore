<?php

use App\Http\Controllers\Store\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');
