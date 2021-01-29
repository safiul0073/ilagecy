<?php

use App\Http\Controllers\API\CallerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\LeadController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\SupplierController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ReportController;

Route::group(['middleware' => 'auth:web'], function () {
    Route::get('/leads/count-status', [ DashboardController::class, 'countStatus']);
    Route::post('/leads/filter-search', [ DashboardController::class, 'filterSearch']);
    Route::get('/leads/get', [LeadController::class, 'getLeads'])->name('leads.get');

    Route::get('/leads/duplicate/get', [LeadController::class, 'getLeadDuplicate'])->name('leads.duplicate.get');

    Route::get('/leads/changeStatus', [LeadController::class, 'changeStatus'])->name('leads.change.status');
    Route::post('/leads/changeNote', [LeadController::class, 'changeNote'])->name('leads.change.note');
    Route::patch('/leads/update', [LeadController::class, 'update'])->name('leads.update');
    Route::delete('/leads/delete', [LeadController::class, 'destroy'])->name('leads.delete');

    Route::post('/leads/postback-endpoint', [LeadController::class, 'postbackEndpoint'])->name('leads.postback');

    Route::get('/users/get', [UserController::class, 'getUsers'])->name('users.get');
    Route::get('/users/trash/get', [UserController::class, 'getTrashUsers'])->name('users.trash.get');
    Route::get('/suppliers/get', [SupplierController::class, 'getSuppliers'])->name('suppliers.get');
    Route::get('/products/get', [ProductController::class, 'getProducts'])->name('products.get');

    Route::get('/reports/get', [ReportController::class, 'getReports'])->name('reports.get');

    Route::get('/reports/get/custom', [ReportController::class, 'getReportsCustom'])->name('reports.get.custom');


    Route::post('/callers/filter-search', [ CallerController::class, 'filterSearch']);
    Route::get('/callers/count-status', [ CallerController::class, 'countStatus']);
});
