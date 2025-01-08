<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('users/login', [UserController::class, 'login']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['middleware' => ['auth:sanctum']], function () {
    //Spesific routes
    Route::get('customers/list', [CustomerController::class, 'list']);
    Route::get('customers/cities', [CustomerController::class, 'cities']);
    Route::get('customers/status', [CustomerController::class, 'status']);
    Route::get('technicians/list', [TechnicianController::class, 'list']);
    Route::get('schedules/print', [ScheduleController::class, 'print']);

    //General routes
    Route::apiResource('schedules', ScheduleController::class);
    Route::apiResource('customers', CustomerController::class);
});
