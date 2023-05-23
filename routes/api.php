<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\KpiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\UserController;
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

Route::name('api.')->middleware('guest')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('login', 'login');
        Route::post('verify', 'verify');
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function () {
        return auth()->user();
    });
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('dynamic-values', [KpiController::class, 'dynamicValues']);
    Route::apiResource('kpis', KpiController::class);
    Route::get('kpis-partials',  [KpiController::class, 'partialKpis']);
    Route::apiResource('users', UserController::class);
    Route::apiResource('departments', DepartmentController::class);
});
