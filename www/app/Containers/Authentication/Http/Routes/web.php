<?php

use App\Containers\Authentication\Http\Controllers\LoginController;

Route::group(
    [
        'middleware' => 'web',
        'prefix' => '/',
    ],
    function () {
        Route::get('/ru/login', [LoginController::class, 'showLoginForm'])->name('loginPage');
        Route::post('/ru/login', [LoginController::class, 'login'])->name('login');
        Route::get('/register', [LoginController::class, 'dump']);
        Route::post('/register', [LoginController::class, 'dump']);
        Route::get('/password/reset', [LoginController::class, 'dump']);
        Route::post('password/email', [LoginController::class, 'dump']);
        Route::get('password/reset/{token}', [LoginController::class, 'dump']);
        Route::post('password/reset', [LoginController::class, 'dump']);
        Route::get('/logout', [LoginController::class, 'logout']);
    }
);
