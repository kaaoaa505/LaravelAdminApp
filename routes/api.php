<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);

// Route::apiResource('users', UserController::class)->middleware('auth:api');
Route::group(['middleware' =>'auth:api' ], function(){
    Route::apiResource('users', UserController::class);
});

