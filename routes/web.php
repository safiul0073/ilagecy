<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('welcome');
Route::get('/products/:id/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashobard');
