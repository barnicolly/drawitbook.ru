<?php

Route::group(
    [
        'middleware' => 'web',
        'namespace' => 'App\Http\Modules\Cron\Controllers'
    ],
    function () {
        Route::get('/vk/post', ['uses' => 'Vk@postImage']);
    });