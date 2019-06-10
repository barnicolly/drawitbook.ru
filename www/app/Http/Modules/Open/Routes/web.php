<?php


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
        Route::post('/art/{id}/claim', ['uses' => 'Claim@register']);
    });

require_once 'Auth/web.php';

require_once 'Search/risunki-po-kletochkam.php';

Route::group(
    [
        'middleware' => 'web',
        'namespace' => 'App\Http\Modules\Open\Controllers'
    ],
    function () {
        Route::get('/', ['uses' => 'Content@index'])
            ->name('home');
    });

//Article
Route::group(
    [
        'middleware' => 'web',
        'namespace' => 'App\Http\Modules\Open\Controllers\Article'
    ],
    function () {
        /*Route::get('/{url}', ['uses' => 'Article@show'])
            ->where('url', '.*')
            ->name('showArticle');*/
    });

