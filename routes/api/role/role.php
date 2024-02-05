<?php

use App\Http\Controllers\Role\RoleController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'role',
    'middleware' => 'auth:api'
], function () {
    // Możliwość pobrania słownika z rolami w edycji użytkownika
    Route::get('/get-all', [RoleController::class, 'getAll'])->middleware(['permission:ADMIN']);

    // Możliwość pobrania słownika z uprawnieniami w edycji roli
    Route::get('/getPermissions', [RoleController::class, 'getPermissions'])->middleware(['permission:PERMISSION_ACCESS']);
    
    Route::get('/', [RoleController::class, 'query'])->middleware(['permission:ROLE_ACCESS']);
    Route::get('/{role}', [RoleController::class, 'getById'])->where('role', '[0-9]+')->middleware(['permission:ROLE_ACCESS']);

    Route::post('/', [RoleController::class, 'store'])->middleware(['permission:ROLE_MANAGE']);
    Route::patch('/', [RoleController::class, 'update'])->middleware(['permission:ROLE_MANAGE']);
    Route::delete('/{role}', [RoleController::class, 'delete'])->middleware(['permission:ROLE_MANAGE']);
});
