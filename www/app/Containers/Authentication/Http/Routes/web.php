<?php

use App\Containers\Authentication\Http\Controllers\LoginController;

//\Illuminate\Support\Facades\Auth::routes();

Route::group(
    [
        'middleware' => 'web',
        'prefix' => '/',
    ],
    function () {
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::get('/register', [LoginController::class, 'dump']);
        Route::post('/register', [LoginController::class, 'dump']);
        Route::get('/password/reset', [LoginController::class, 'dump']);
        Route::post('password/email', [LoginController::class, 'dump']);
        Route::get('password/reset/{token}', [LoginController::class, 'dump']);
        Route::post('password/reset', [LoginController::class, 'dump']);
        Route::get('/logout', [LoginController::class, 'logout']);
    }
);
