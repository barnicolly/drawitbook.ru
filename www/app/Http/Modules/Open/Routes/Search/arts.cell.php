<?php

Route::group(
    [
        'middleware' => 'web',
        'namespace' => 'App\Http\Modules\Open\Controllers\Search'
    ],
    function () {
        Route::get('/search', ['uses' => 'Search@index'])->name('search');
        Route::get('/risunki-po-kletochkam/{tag}', ['uses' => 'ArtsCell@tagged'])->name('arts.cell.tagged');
    });