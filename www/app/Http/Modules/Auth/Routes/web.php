<?php

use App\Http\Modules\Auth\Controllers\Login;

Route::group(
    [
        'middleware' => 'web',
        'prefix' => '/',
    ],
    function () {
        Route::get('/login', [Login::class, 'showLoginForm'])->name('login');
        Route::get('/register', [Login::class, 'dump']);
        Route::post('/register', [Login::class, 'dump']);
        Route::get('/password/reset', [Login::class, 'dump']);
        Route::post('password/email', [Login::class, 'dump']);
        Route::get('password/reset/{token}', [Login::class, 'dump']);
        Route::post('password/reset', [Login::class, 'dump']);
        Route::get('/logout', [Login::class, 'logout']);
    }
);
