<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'page',
    'middleware' => 'auth:api'
], function () {
    Route::get('/', function () {
        return 'Obszar chroniony przez API.';
    });

    Route::get('/subpage', function () {
        return 'Obszar chroniony przez API i dodatkowo uprawnieniem.';
    })->middleware(['permission:ADMIN']);
});
