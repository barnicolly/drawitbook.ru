<?php

Route::group(
    [
        'middleware' => 'web',
        'prefix' => '/',
        'namespace' => 'App\Http\Modules\Auth\Controllers'
    ],
    function () {
        Route::get('/login', ['uses' => 'Login@showLoginForm'])->name('login');
        Route::get('/register', ['uses' => 'Login@dump']);
        Route::post('/register', ['uses' => 'Login@dump']);
        Route::get('/password/reset', ['uses' => 'Login@dump']);
        Route::post('password/email', ['uses' => 'Login@dump']);
        Route::get('password/reset/{token}', ['uses' => 'Login@dump']);
        Route::post('password/reset', ['uses' => 'Login@dump']);
    });