<?php

Route::group(
    [
        'middleware' => 'web',
        'namespace' => 'App\Http\Modules\Content\Controllers'
    ],
    function () {
        Route::get('/', ['uses' => 'Content@index'])
            ->name('home');

        Route::get('/tag/list', ['uses' => 'Content@tagList'])->middleware(['ajax']);
    });

Route::group(
    [
        'middleware' => 'web',
        'namespace' => 'App\Http\Modules\Content\Controllers'
    ],
    function () {
        Route::get('/search', ['uses' => 'Search@index'])->name('search');

        Route::get('/search/slice', ['uses' => 'Search@slice'])->name('search.slice');
    });
