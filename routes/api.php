<?php

use App\Http\Controllers\API\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::group(['middleware' => 'auth'], function () {
Route::group(['middleware' => 'sessions'], function () {
    Route::get('/leads/count-status', [DashboardController::class, 'countStatus']);
    Route::post('/leads/filter-search', [DashboardController::class, 'filterSearch']);
});
// });
