<?php

use App\Http\Controllers\Frontend\DashboardController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\LeadController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\SupplierController;
use App\Http\Controllers\Frontend\UserController;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('product.list');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/users', UserController::class);
    Route::get('/user/trash', [UserController::class , 'trash'])->name('users.trash');
    Route::get('/user/restore/{id}', [UserController::class , 'restore'])->name('users.restore');
    Route::get('/user/restoreAll', [UserController::class , 'restoreAll'])->name('users.restore.all');

    Route::resource('/suppliers', SupplierController::class);
    Route::resource('/products', ProductController::class);
    Route::get('/leads/list', [LeadController::class, 'index'])->name('leads.list');
});

Route::prefix('api')->group(base_path('routes/customApi.php'));

// Route::get('/temp', [HomeController::class, 'temp']);
