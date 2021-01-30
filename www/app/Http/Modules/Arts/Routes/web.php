<?php

foreach (config('translator.available_locales') as $prefix) {
    Route::group(
        ['prefix' => $prefix],
        function () use ($prefix) {
            Route::group(
                [
                    'prefix' => Lang::get('routes.pixel_arts', [], $prefix),
                    'middleware' => 'web',
                    'namespace' => 'App\Http\Modules\Arts\Controllers',
                ],
                function () use ($prefix) {
                    Route::group(
                        [
                            'middleware' => ['lower_case', 'no_get'],
                        ],
                        function () use ($prefix) {
                            Route::get('/', ['uses' => 'Cell@index'])
                                ->name($prefix . '_arts.cell');

                            Route::get('/{tag}', ['uses' => 'Cell@tagged'])
                                ->name($prefix . '_arts.cell.tagged');
                        }
                    );

                    Route::get('/{tag}/slice', ['uses' => 'Cell@slice']);
                }
            );

            Route::group(
                [
                    'prefix' => '/arts',
                    'middleware' => 'web',
                    'namespace' => 'App\Http\Modules\Arts\Controllers\Art',
                ],
                function () use ($prefix) {
                    Route::get('/{id}', ['uses' => 'Art@index'])
                        ->middleware(['lower_case', 'no_get'])
                        ->name($prefix . '_art');

                    Route::group(
                        [
                            'middleware' => ['ajax'],
                        ],
                        function () {
                            Route::post('/{id}/like', ['uses' => 'Rate@like']);
                            Route::post('/{id}/dislike', ['uses' => 'Rate@dislike']);
                            Route::post('/{id}/claim', ['uses' => 'Claim@register']);
                        }
                    );
                }
            );
        }
    );
}
