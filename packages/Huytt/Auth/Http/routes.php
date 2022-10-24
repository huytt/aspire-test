<?php

use Huytt\Auth\Http\Controllers\AdminAuthController;
use Huytt\Auth\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'api/v1'], function () {
    Route::group(['middleware' => 'api'], function () {
        Route::post('login', [AuthController::class, 'authenticate']);
        Route::post('register', [AuthController::class, 'register']);

        Route::group(['middleware' => ['jwt.auth']], function() {
            Route::get('logout', [AuthController::class, 'logout']);
            Route::get('me', [AuthController::class, 'me']);
        });
    });

    Route::group(['prefix' => 'admin'], function () {
        Route::post('login', [AdminAuthController::class, 'authenticate']);
        Route::post('register', [AdminAuthController::class, 'register']);
        Route::group(['middleware' => ['auth:admin-api', 'jwt.auth']], function() {
            Route::get('logout', [AdminAuthController::class, 'logout']);
            Route::get('me', [AdminAuthController::class, 'me']);
        });
    });
});
