<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'api/v1'], function () {
    Route::group(['prefix' => 'users'], function () {
        Route::post('register', [\Huytt\User\Http\Controllers\UserController::class, 'register']);

        Route::group(['middleware' => 'jwt.auth'], function () {
//            Route::get('/', [\Huytt\User\Http\Controllers\UserController::class, 'index']);
        });
    });

});
