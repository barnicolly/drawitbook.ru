<?php

Route::group(
    [
        'middleware' => 'web',
        'namespace' => 'App\Http\Modules\Content\Controllers'
    ],
    function () {
        Route::get('/', ['uses' => 'Content@index'])->name('home');
        Route::get('/art/{id}', ['uses' => 'Content@art'])->name('art');
        Route::post('/art/like/{id}', ['uses' => 'Content@like']);
        Route::post('/art/dislike/{id}', ['uses' => 'Content@dislike']);
    });