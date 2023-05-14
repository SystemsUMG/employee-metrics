<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\KpiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::name('api.')->middleware('guest')->group(function () { //TODO: set middleware login
    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('kpis', KpiController::class);
    });

    Route::prefix('/')->middleware('guest')->group(function () {
        Route::controller(AuthController::class)->group(function () {
            Route::post('login', 'login');
            Route::post('register', 'register');
        });
        Route::get('dynamic-values', [KpiController::class, 'dynamicValues']);
    });
});
