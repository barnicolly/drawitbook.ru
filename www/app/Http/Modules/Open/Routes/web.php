<?php

//Article
Route::group(
    [
        'middleware' => 'web',
        'namespace' => 'App\Http\Modules\Open\Controllers'
    ],
    function () {
        /*Route::get('/', ['uses' => 'Content@index'])->name('home');
        Route::get('/art/{id}', ['uses' => 'Content@art'])->name('art');
        Route::post('/art/like/{id}', ['uses' => 'Rate@like']);
        Route::post('/art/dislike/{id}', ['uses' => 'Rate@dislike']);
        Route::post('/art/claim/{id}', ['uses' => 'Claim@register']);


        Route::get('/search', ['uses' => 'Search@index'])
            ->name('search');
        Route::get('/{url}', ['uses' => 'Article@show'])
            ->where('url', '.*')
            ->name('showArticle');*/
    });

//Art
Route::group(
    [
        'middleware' => 'web',
        'namespace' => 'App\Http\Modules\Open\Controllers\Picture'
    ],
    function () {
        Route::get('/art/{id}', ['uses' => 'Picture@index'])->name('art');
        Route::post('/art/{id}/like', ['uses' => 'Rate@likeJson'])->middleware(['ajax']);
        Route::post('/art/{id}/dislike', ['uses' => 'Rate@dislikeJson'])->middleware(['ajax']);
//        Route::post('/art/claim/{id}', ['uses' => 'Claim@register']);


       /* Route::get('/search', ['uses' => 'Search@index'])
            ->name('search');
        Route::get('/{url}', ['uses' => 'Article@show'])
            ->where('url', '.*')
            ->name('showArticle');*/
    });

Route::group(
    [
        'middleware' => 'web',
        'namespace' => 'App\Http\Modules\Open\Controllers'
    ],
    function () {
        /*Route::get('/', ['uses' => 'Content@index'])->name('home');
        Route::get('/art/{id}', ['uses' => 'Content@art'])->name('art');
        Route::post('/art/like/{id}', ['uses' => 'Rate@like']);
        Route::post('/art/dislike/{id}', ['uses' => 'Rate@dislike']);
        Route::post('/art/claim/{id}', ['uses' => 'Claim@register']);


        Route::get('/search', ['uses' => 'Search@index'])
            ->name('search');
        Route::get('/{url}', ['uses' => 'Article@show'])
            ->where('url', '.*')
            ->name('showArticle');*/

    });