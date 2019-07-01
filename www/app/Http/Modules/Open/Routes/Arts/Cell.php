<?php

Route::group(
    [
        'middleware' => 'web',
        'namespace' => 'App\Http\Modules\Open\Controllers\Picture'
    ],
    function () {
        Route::get('/risunki-po-kletochkam', ['uses' => 'ArtsCell@index'])->name('arts.cell');
    });