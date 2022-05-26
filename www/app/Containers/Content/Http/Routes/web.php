<?php

use App\Containers\Content\Http\Controllers\ContentController;

foreach (config('translator.available_locales') as $prefix) {
    Route::group(
        ['prefix' => $prefix],
        function () use ($prefix) {
            Route::group(
                [
                    'middleware' => 'web',
                ],
                function () use ($prefix) {
                    Route::get('/', [ContentController::class, 'index'])
                        ->middleware(['lower_case', 'no_get'])
                        ->name($prefix . '_home');

                    Route::get('/tag/list', [ContentController::class, 'tagList'])
                        ->middleware(['ajax']);
                }
            );
        });
}
