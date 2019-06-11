<?php

Route::group(
    [
        'middleware' => 'web',
        'namespace' => 'App\Http\Modules\Open\Controllers\Search'
    ],
    function () {
        Route::get('/risunki-po-kletochkam', ['uses' => 'RisunkiPoKletochkam@search'])->name('risunkiPoKletochkam.search');
        Route::get('/search', ['uses' => 'Search@index'])->name('search');
        Route::get('/risunki-po-kletochkam/tagged/{tag}', ['uses' => 'RisunkiPoKletochkam@tagged'])->name('risunkiPoKletochkam.tagged');
    });