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

require_once 'Search/arts.cell.php';
require_once 'Arts/Cell.php';

Route::group(
    [
        'middleware' => 'web',
        'namespace' => 'App\Http\Modules\Open\Controllers'
    ],
    function () {
        Route::get('/', ['uses' => 'Content@index'])
            ->name('home');

        Route::get('/tag/list', ['uses' => 'Content@tagList'])->middleware(['ajax']);
    });
