<?php

use App\Http\Controllers\Frontend\DashboardController;
use App\Http\Controllers\Frontend\HomeController;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('product.list');
    Route::get('/dashboard/{product_id}', [DashboardController::class, 'index'])->name('dashboard');
});
