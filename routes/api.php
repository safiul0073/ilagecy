<?php

use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\LeadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::group(['middleware' => 'auth'], function () {
    Route::get('/leads/count-status', [DashboardController::class, 'countStatus']);
    Route::post('/leads/filter-search', [DashboardController::class, 'filterSearch']);
    Route::get('/leads/get', [LeadController::class, 'getLeads'])->name('leads.get');

    Route::get('/leads/changeStatus', [LeadController::class, 'changeStatus'])->name('leads.change.status');
    Route::post('/leads/changeNote', [LeadController::class, 'changeNote'])->name('leads.change.note');
    Route::patch('/leads/update', [LeadController::class, 'update'])->name('leads.update');
    Route::delete('/leads/delete', [LeadController::class, 'destroy'])->name('leads.delete');

    Route::post('/leads/postback-endpoint', [LeadController::class, 'postbackEndpoint'])->name('leads.postback');

// });
