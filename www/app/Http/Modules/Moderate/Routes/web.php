<?php

Route::group(
    [
//        'middleware' => 'web',
        'prefix' => '/moderate',
        'namespace' => 'App\Http\Modules\Moderate\Controllers'
    ],
    function () {
        Route::get('/', ['uses' => 'Moderate@index']);
    });