<?php

Route::group(
    [
        'middleware' => 'web',
        'prefix' => '/',
        'namespace' => 'App\Http\Modules\Auth\Controllers'
    ],
    function () {
        Route::get('/login', ['uses' => 'Login@showLoginForm'])->name('login');
        Route::get('/register', ['uses' => 'Register@showRegistrationForm'], function () {
            return redirect()->route('login');
        });
        Route::post('/register', function () {
            return redirect()->route('login');
        });
        Route::get('/password/reset', function () {
            return redirect()->route('login');
        });
        Route::post('password/email', function () {
            return redirect()->route('login');
        });
        Route::get('password/reset/{token}', function () {
            return redirect()->route('login');
        });
        Route::post('password/reset', function () {
            return redirect()->route('login');
        });
    });