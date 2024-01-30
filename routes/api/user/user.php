<?php

use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'user',
    'middleware' => 'auth:api'
], function () {
    Route::get('/get-all', [UserController::class, 'getAll'])->middleware(['permission:USER_ACCESS']);
    Route::get('/', [UserController::class, 'query'])->middleware(['permission:USER_ACCESS']);
    Route::get('/deleted', [UserController::class, 'queryDeleted'])->middleware(['permission:USER_ACCESS']);
    Route::get('/{user}', [UserController::class, 'getById'])->where('user', '[0-9]+')->middleware(['permission:USER_ACCESS']);

    Route::post('/', [UserController::class, 'create'])->middleware(['permission:USER_MANAGE']);
    Route::patch('/', [UserController::class, 'update'])->middleware(['permission:USER_MANAGE']);

    Route::patch('/{user}/change-password', [UserController::class, 'changePassword'])->middleware(['permission:USER_MANAGE']);
    Route::delete('/{user}', [UserController::class, 'delete'])->middleware(['permission:USER_MANAGE']);
    Route::post('/{id}/restore', [UserController::class, 'restore'])->middleware(['permission:USER_MANAGE']);
});
