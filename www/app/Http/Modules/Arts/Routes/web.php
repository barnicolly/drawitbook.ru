<?php

Route::group(
    [
        'middleware' => 'web',
        'namespace' => 'App\Http\Modules\Arts\Controllers'
    ],
    function () {
        Route::get('/risunki-po-kletochkam', ['uses' => 'Cell@index'])->name('arts.cell');

        Route::get('/risunki-po-kletochkam/{tag}', ['uses' => 'Cell@tagged'])->name('arts.cell.tagged');
    });

Route::group(
    [
        'middleware' => 'web',
        'namespace' => 'App\Http\Modules\Arts\Controllers\Art'
    ],
    function () {
        Route::get('/arts/{id}', ['uses' => 'Art@index'])->name('art');
        Route::post('/arts/{id}/like', ['uses' => 'Rate@like'])->middleware(['ajax']);
        Route::post('/arts/{id}/dislike', ['uses' => 'Rate@dislike'])->middleware(['ajax']);
        Route::post('/arts/{id}/claim', ['uses' => 'Claim@register']);
    });
