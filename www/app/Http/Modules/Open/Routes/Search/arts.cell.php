<?php

Route::group(
    [
        'middleware' => 'web',
        'namespace' => 'App\Http\Modules\Open\Controllers\Search'
    ],
    function () {
//        Route::get('/risunki-po-kletochkam', ['uses' => 'RisunkiPoKletochkam@search'])->name('search_cell');
//        Route::get('/risunki-po-kletochkam', ['uses' => 'ArtsCell@search'])->name('arts.cell');
        Route::get('/search', ['uses' => 'Search@index'])->name('search');
        Route::get('/risunki-po-kletochkam/tagged/{tag}', ['uses' => 'ArtsCell@tagged'])->name('risunkiPoKletochkam.tagged');
    });