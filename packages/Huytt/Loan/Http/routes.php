<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'api/v1'], function () {
    Route::group(['prefix' => 'loans/me'], function () {
        Route::group(['middleware' => 'jwt.auth'], function () {
            Route::get('/list', [\Huytt\Loan\Http\Controllers\LoanController::class, 'meList']);
            Route::post('/store', [\Huytt\Loan\Http\Controllers\LoanController::class, 'store']);
        });
    });

});
