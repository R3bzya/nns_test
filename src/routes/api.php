<?php

use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\Employee\EmployeeExportController;
use App\Http\Controllers\User\UserAuthController;
use App\Http\Middleware\Employee\EmployeeSelfTreeMiddleware;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth/user'], function () {
    Route::post('/register', [UserAuthController::class, 'register']);
    Route::post('/login', [UserAuthController::class, 'login']);
});

Route::group(['prefix' => 'employees', 'middleware' => ['auth:api']], function () {
    Route::post('/create', [EmployeeController::class, 'create']);

    Route::group(['middleware' => EmployeeSelfTreeMiddleware::class], function () {
        Route::group(['prefix' => '{employee}'], function () {
            Route::get('/descendants', [EmployeeController::class, 'descendants']);
            Route::get('/children', [EmployeeController::class, 'children']);
            Route::get('/children-export', [EmployeeExportController::class, 'children']);
            Route::get('/descendants-export', [EmployeeExportController::class, 'descendants']);
        });
    });
});
