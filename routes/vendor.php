<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Vendor\Auth\AuthController;
use App\Http\Controllers\Vendor\DashboardController;

Route::prefix('vendor')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('vendor.login');
    Route::post('/login', [AuthController::class, 'login'])->name('vendor.login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth.vendor')->name('vendor.logout');

    Route::middleware('auth.vendor')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('vendor.dashboard');
    });
});
