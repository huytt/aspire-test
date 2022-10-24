<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'api/v1'], function () {
    Route::group(['prefix' => 'loans'], function () {
        Route::group(['middleware' => 'jwt.auth'], function () {
//            Route::get('/', [\Huytt\Loan\Http\Controllers\UserController::class, 'index']);
            Route::post('/store', [\Huytt\Loan\Http\Controllers\LoanController::class, 'store']);
        });
    });

});
