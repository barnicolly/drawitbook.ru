<?php

Route::group(
    [
        'middleware' => 'web',
        'namespace' => 'App\Http\Modules\Content\Controllers'
    ],
    function () {
        Route::get('/', ['uses' => 'Content@index'])->name('home');
        Route::get('/sample', ['uses' => 'Content@index'])->name('sample');
        Route::get('/art/{id}', ['uses' => 'Content@art'])->name('art');
        Route::post('/art/like/{id}', ['uses' => 'Rate@like']);
        Route::post('/art/dislike/{id}', ['uses' => 'Rate@dislike']);
        Route::post('/art/claim/{id}', ['uses' => 'Claim@register']);
    });