<?php

use App\Containers\Picture\Http\Controllers\Art\ArtHttpController;
use App\Containers\Picture\Http\Controllers\Art\ClaimAjaxController;
use App\Containers\Picture\Http\Controllers\Art\RateAjaxController;
use App\Containers\Picture\Http\Controllers\Cell\CellAjaxController;
use App\Containers\Picture\Http\Controllers\Cell\CellHttpController;

foreach (config('translator.available_locales') as $prefix) {
    Route::group(
        ['prefix' => $prefix],
        static function () use ($prefix) : void {
            Route::group(
                [
                    'prefix' => Lang::get('routes.pixel_arts', [], $prefix),
                    'middleware' => 'web',
                ],
                static function () use ($prefix) : void {
                    Route::group(
                        [
                            'middleware' => ['lower_case', 'no_get'],
                        ],
                        static function () use ($prefix) : void {
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
                static function () use ($prefix) : void {
                    Route::get('/{id}', (new ArtHttpController())->index(...))
                        ->middleware(['lower_case', 'no_get'])
                        ->name($prefix . '_art');
                    Route::group(
                        [
                            'middleware' => ['ajax'],
                        ],
                        static function () : void {
                            Route::post('/{id}/like', (new RateAjaxController())->like(...));
                        }
                    );
                    Route::group(
                        [
                            'middleware' => ['ajax'],
                        ],
                        static function () : void {
                            Route::post('/{id}/claim', (new ClaimAjaxController())->register(...));
                        }
                    );
                }
            );
        }
    );
}
