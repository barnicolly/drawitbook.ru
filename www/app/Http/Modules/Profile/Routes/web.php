<?php

Route::group(
    [
        'middleware' => 'web',
        'prefix' => '/profile',
        'namespace' => 'App\Http\Modules\Profile\Controllers'
    ],
    function () {
        Route::get('/', ['uses' => 'Profile@index'])->name('profile');
    });