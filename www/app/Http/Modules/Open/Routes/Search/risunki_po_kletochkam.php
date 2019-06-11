<?php

Route::group(
    [
        'middleware' => 'web',
        'namespace' => 'App\Http\Modules\Open\Controllers\Search'
    ],
    function () {
        Route::get('/search', ['uses' => 'Search@index'])
            ->name('search');
        Route::get('/risunki-po-kletochkam/tagged/{tag}', ['uses' => 'RisunkiPoKletochkam@tagged'])->name('risunkiPoKletochkam.tagged');
    });