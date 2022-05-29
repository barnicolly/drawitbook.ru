<?php

use App\Containers\Picture\Http\Controllers\Art\ArtHttpController;
use App\Containers\Picture\Http\Controllers\Art\ClaimHttpController;
use App\Containers\Picture\Http\Controllers\Art\RateHttpController;
use App\Containers\Picture\Http\Controllers\CellHttpController;

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

                    Route::get('/{tag}/slice', [CellHttpController::class, 'slice']);
                }
            );

            Route::group(
                [
                    'prefix' => '/arts',
                    'middleware' => 'web',
                ],
                function () use ($prefix) {
                    Route::get('/{id}', [ArtHttpController::class, 'index'])
                        ->middleware(['lower_case', 'no_get'])
                        ->name($prefix . '_art');

                    Route::group(
                        [
                            'middleware' => ['ajax'],
                        ],
                        function () {
                            Route::post('/{id}/like', [RateHttpController::class, 'like']);
                            Route::post('/{id}/dislike',[RateHttpController::class, 'dislike']);
                            Route::post('/{id}/claim', [ClaimHttpController::class, 'register']);
                        }
                    );
                }
            );
        }
    );
}
