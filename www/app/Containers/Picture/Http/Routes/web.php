<?php

use App\Containers\Picture\Http\Controllers\Art\ArtController;
use App\Containers\Picture\Http\Controllers\Art\ClaimController;
use App\Containers\Picture\Http\Controllers\Art\RateController;
use App\Containers\Picture\Http\Controllers\CellController;

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
                            Route::get('/', [CellController::class, 'index'])
                                ->name($prefix . '_arts.cell');

                            Route::get('/{tag}', [CellController::class, 'tagged'])
                                ->name($prefix . '_arts.cell.tagged');
                        }
                    );

                    Route::get('/{tag}/slice', [CellController::class, 'slice']);
                }
            );

            Route::group(
                [
                    'prefix' => '/arts',
                    'middleware' => 'web',
                ],
                function () use ($prefix) {
                    Route::get('/{id}', [ArtController::class, 'index'])
                        ->middleware(['lower_case', 'no_get'])
                        ->name($prefix . '_art');

                    Route::group(
                        [
                            'middleware' => ['ajax'],
                        ],
                        function () {
                            Route::post('/{id}/like', [RateController::class, 'like']);
                            Route::post('/{id}/dislike',[RateController::class, 'dislike']);
                            Route::post('/{id}/claim', [ClaimController::class, 'register']);
                        }
                    );
                }
            );
        }
    );
}
