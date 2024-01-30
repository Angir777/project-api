<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('register', [RegisterController::class, 'register']);
    Route::get('confirm-account/{confirmationCode}', [RegisterController::class, 'confirmAccount']);

    Route::post('send-reset-password-email', [ResetPasswordController::class, 'sendResetPasswordEmail']);
    Route::post('reset-password', [ResetPasswordController::class, 'resetPassword']);

    Route::post('login', [LoginController::class, 'login']);
    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::get('logout', [LoginController::class, 'logout']);
    });
});
