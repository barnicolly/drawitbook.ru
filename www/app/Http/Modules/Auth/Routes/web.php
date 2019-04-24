<?php

Route::group(
    [
        'middleware' => 'web',
        'prefix' => '/',
        'namespace' => 'App\Http\Modules\Auth\Controllers'
    ],
    function () {
        Route::get('/login', ['uses' => 'Login@showLoginForm'])->name('login');
        Route::get('/register', ['uses' => 'Register@showRegistrationForm'])
            ->name('register');
    });