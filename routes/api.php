<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorksheetController;
use App\Models\Dashboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('users/login', [UserController::class, 'login']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['middleware' => ['auth:sanctum']], function () {
    //Spesific routes
    Route::delete('users/destroy', [UserController::class, 'destroy']);
    Route::get('customers/list', [CustomerController::class, 'list']);
    Route::get('customers/cities', [CustomerController::class, 'cities']);
    Route::get('customers/status', [CustomerController::class, 'status']);
    Route::get('technicians/list', [TechnicianController::class, 'list']);
    Route::get('schedules/print', [ScheduleController::class, 'print']);
    Route::get('schedules/empty', [ScheduleController::class, 'empty']);
    Route::post('schedules/assign', [ScheduleController::class, 'assign']);
    Route::get('dashboard/stats', [DashboardController::class, 'stats']);
    Route::get('worksheets/{date}', [WorksheetController::class, 'getWorksheets']);

    //General routes
    Route::apiResource('schedules', ScheduleController::class);
    Route::apiResource('customers', CustomerController::class);
    //Products
    Route::apiResource('products', ProductController::class);
});
