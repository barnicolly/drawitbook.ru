<?php

Route::group(
    [
        'middleware' => 'web',
        'namespace' => 'App\Http\Modules\Content\Controllers'
    ],
    function () {
        Route::get('/', ['uses' => 'Content@index'])->name('home');
     /*   Route::get('/art/{id}', ['uses' => 'Content@art'])->name('art');
        Route::post('/art/like/{id}', ['uses' => 'Rate@like']);
        Route::post('/art/dislike/{id}', ['uses' => 'Rate@dislike']);
        Route::post('/art/claim/{id}', ['uses' => 'Claim@register']);*/


        Route::get('/search', ['uses' => 'Search@index'])
            ->name('search');
       /* Route::get('/{url}', ['uses' => 'Article@show'])
            ->where('url', '.*')
            ->name('showArticle');*/
    });