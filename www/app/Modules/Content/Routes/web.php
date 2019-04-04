<?php

Route::group(
    [
//        'middleware' => 'web',
        'namespace' => 'App\Modules\Content\Controllers'
    ],
    function () {
        Route::get('/', ['uses' => 'Content@index']);
    });