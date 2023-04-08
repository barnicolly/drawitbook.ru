<?php

use App\Containers\Picture\Http\Controllers\Art\ArtHttpController;
use App\Containers\Picture\Http\Controllers\Art\ClaimAjaxController;
use App\Containers\Picture\Http\Controllers\Art\RateAjaxController;
use App\Containers\Picture\Http\Controllers\Cell\CellAjaxController;
use App\Containers\Picture\Http\Controllers\Cell\CellHttpController;

foreach (config('translator.available_locales') as $prefix) {
    Route::group(
        ['prefix' => $prefix],
        function () use ($prefix) {
            Route::group(
                [
                    'prefix' => Lang::get('routes.pixel_arts', [], $prefix),
                    'middleware' => 'web',
                ],
                function () use ($prefix) {
                    Route::group(
                        [
                            'middleware' => ['lower_case', 'no_get'],
                        ],
                        function () use ($prefix) {
                            Route::get('/', [CellHttpController::class, 'index'])
                                ->name($prefix . '_arts.cell');

                            Route::get('/{tag}', [CellHttpController::class, 'tagged'])
                                ->name($prefix . '_arts.cell.tagged');
                        }
                    );

                    Route::get('/{tag}/slice', (new CellAjaxController())->slice(...))
                        ->middleware('ajax');
                }
            );

            Route::group(
                [
                    'prefix' => '/arts',
                    'middleware' => 'web',
                ],
                function () use ($prefix) {
                    Route::get('/{id}', (new ArtHttpController())->index(...))
                        ->middleware(['lower_case', 'no_get'])
                        ->name($prefix . '_art');

                    Route::group(
                        [
                            'middleware' => ['ajax'],
                        ],
                        function () {
                            Route::post('/{id}/like', (new RateAjaxController())->like(...));
                        }
                    );

                    Route::group(
                        [
                            'middleware' => ['ajax'],
                        ],
                        function () {
                            Route::post('/{id}/claim', (new ClaimAjaxController())->register(...));
                        }
                    );
                }
            );
        }
    );
}
