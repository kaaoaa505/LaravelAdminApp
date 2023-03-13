<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);

Route::post('register', [AuthController::class, 'register']);


// Route::apiResource('users', UserController::class)->middleware('auth:api');
Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResource('users', UserController::class);

    Route::apiResource('roles', RoleController::class);

    Route::apiResource('permissions', PermissionController::class)->only('index');

    Route::apiResource('products', ProductController::class);

    Route::apiResource('orders', OrderController::class)->only('index', 'show');
    Route::get('export', [OrderController::class, 'export']);

    Route::get('chart', [DashboardController::class, 'chart']);

    Route::get('user', [UserController::class, 'user']);
    Route::put('user/info/update', [UserController::class, 'userInfoUpdate']);
    Route::put('user/password/update', [UserController::class, 'userPasswordUpdate']);

    Route::post('logout', [AuthController::class, 'logout']);
});
