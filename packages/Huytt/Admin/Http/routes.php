<?php

use Huytt\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'api/v1'], function () {
    Route::group(['prefix' => 'admin'], function () {
        Route::post('register', [AdminController::class, 'register']);

        Route::group(['middleware' => 'jwt.auth'], function () {
//            Route::get('/', [\Huytt\User\Http\Controllers\UserController::class, 'index']);
        });
    });

});
