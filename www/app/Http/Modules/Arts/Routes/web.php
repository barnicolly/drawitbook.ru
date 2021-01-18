<?php

Route::group(
    [
        'prefix' => '/risunki-po-kletochkam',
        'middleware' => 'web',
        'namespace' => 'App\Http\Modules\Arts\Controllers'
    ],
    function () {

        Route::group(
            [
                'middleware' => ['lower_case', 'no_get'],
            ],
            function () {
                Route::get('/', ['uses' => 'Cell@index'])
                    ->name('arts.cell');

                Route::get('/{tag}', ['uses' => 'Cell@tagged'])
                    ->name('arts.cell.tagged');
            });

        Route::get('/{tag}/slice', ['uses' => 'Cell@slice'])
            ->name('arts.cell.tagged.slice');
    });

Route::group(
    [
        'prefix' => '/arts',
        'middleware' => 'web',
        'namespace' => 'App\Http\Modules\Arts\Controllers\Art'
    ],
    function () {
        Route::get('/{id}', ['uses' => 'Art@index'])
            ->middleware(['lower_case', 'no_get'])
            ->name('art');

        Route::group(
            [
                'middleware' => ['ajax'],
            ],
            function () {
                Route::post('/{id}/like', ['uses' => 'Rate@like']);
                Route::post('/{id}/dislike', ['uses' => 'Rate@dislike']);
                Route::post('/{id}/claim', ['uses' => 'Claim@register']);
            });

    });
