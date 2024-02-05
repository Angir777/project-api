<?php

use App\Http\Controllers\Account\AccountController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'account',
    'middleware' => 'auth:api'
], function () {
    Route::patch('change-password', [AccountController::class, 'changePassword']);
    Route::delete('dalete-account', [AccountController::class, 'daleteAccount']);
});
