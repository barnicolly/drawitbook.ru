<?php

Route::group(
    [
        'middleware' => 'web',
        'prefix' => '/admin',
        'namespace' => 'App\Http\Modules\Admin\Controllers'
    ],
    function () {
        Route::get('/moderate', ['uses' => 'Moderate@index']);
    });