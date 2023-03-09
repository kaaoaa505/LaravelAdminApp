<?php

use App\Http\Controllers\AuthController;
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

    Route::apiResource('products', ProductController::class);

    Route::get('user', [UserController::class, 'user']);

    Route::put('user/info/update', [UserController::class, 'userInfoUpdate']);

    Route::put('user/password/update', [UserController::class, 'userPasswordUpdate']);
});
