<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'api/v1'], function () {
    Route::group(['prefix' => 'loans/me'], function () {
        Route::group(['middleware' => 'jwt.auth'], function () {
            Route::get('/list', [\Huytt\Loan\Http\Controllers\LoanController::class, 'meList']);
            Route::post('/store', [\Huytt\Loan\Http\Controllers\LoanController::class, 'store']);
            Route::put('/repayment/{id}', [\Huytt\Loan\Http\Controllers\LoanController::class, 'repayment']);
        });
    });

    Route::group(['prefix' => 'loans/admin'], function () {
        Route::group(['middleware' => ['auth:admin-api', 'jwt.auth']], function () {
            Route::put('/approve/{id}', [\Huytt\Loan\Http\Controllers\LoanController::class, 'approve']);
        });

    });

});
