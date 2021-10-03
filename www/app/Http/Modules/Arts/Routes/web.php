<?php

use App\Http\Modules\Arts\Controllers\Art\Art;
use App\Http\Modules\Arts\Controllers\Art\Claim;
use App\Http\Modules\Arts\Controllers\Art\Rate;
use App\Http\Modules\Arts\Controllers\Cell;

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
                            Route::get('/', [Cell::class, 'index'])
                                ->name($prefix . '_arts.cell');

                            Route::get('/{tag}', [Cell::class, 'tagged'])
                                ->name($prefix . '_arts.cell.tagged');
                        }
                    );

                    Route::get('/{tag}/slice', [Cell::class, 'slice']);
                }
            );

            Route::group(
                [
                    'prefix' => '/arts',
                    'middleware' => 'web',
                ],
                function () use ($prefix) {
                    Route::get('/{id}', [Art::class, 'index'])
                        ->middleware(['lower_case', 'no_get'])
                        ->name($prefix . '_art');

                    Route::group(
                        [
                            'middleware' => ['ajax'],
                        ],
                        function () {
                            Route::post('/{id}/like', [Rate::class, 'like']);
                            Route::post('/{id}/dislike',[Rate::class, 'dislike']);
                            Route::post('/{id}/claim', [Claim::class, 'register']);
                        }
                    );
                }
            );
        }
    );
}
