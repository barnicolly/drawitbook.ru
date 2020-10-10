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

Route::group(
    [
        'middleware' => 'web',
        'namespace' => 'App\Http\Modules\Open\Controllers\Search'
    ],
    function () {
        Route::get('/search', ['uses' => 'Search@index'])->name('search');
        Route::get('/risunki-po-kletochkam/{tag}', ['uses' => 'ArtsCell@tagged'])->name('arts.cell.tagged');
    });

Route::group(
    [
        'middleware' => 'web',
        'namespace' => 'App\Http\Modules\Open\Controllers\Picture'
    ],
    function () {
        Route::get('/risunki-po-kletochkam', ['uses' => 'ArtsCell@index'])->name('arts.cell');
    });

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

Route::group(
    [
        'middleware' => 'web',
        'prefix' => '/',
        'namespace' => 'App\Http\Modules\Open\Controllers\Auth'
    ],
    function () {
        Route::get('/login', ['uses' => 'Login@showLoginForm'])->name('login');
        Route::get('/register', ['uses' => 'Login@dump']);
        Route::post('/register', ['uses' => 'Login@dump']);
        Route::get('/password/reset', ['uses' => 'Login@dump']);
        Route::post('password/email', ['uses' => 'Login@dump']);
        Route::get('password/reset/{token}', ['uses' => 'Login@dump']);
        Route::post('password/reset', ['uses' => 'Login@dump']);
    });
