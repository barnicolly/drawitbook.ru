<?php

use App\Http\Modules\Content\Controllers\Content;
use App\Http\Modules\Content\Controllers\Search;

foreach (config('translator.available_locales') as $prefix) {
    Route::group(
        ['prefix' => $prefix],
        function () use ($prefix) {
            Route::group(
                [
                    'middleware' => 'web',
                ],
                function () use ($prefix) {
                    Route::get('/', [Content::class, 'index'])
                        ->middleware(['lower_case', 'no_get'])
                        ->name($prefix . '_home');

                    Route::get('/tag/list', [Content::class, 'tagList'])
                        ->middleware(['ajax']);
                }
            );

            Route::group(
                [
                    'middleware' => 'web',
                ],
                function () use ($prefix) {
                    Route::get('/search', [Search::class, 'index'])->name($prefix . '_search');

                    Route::get('/search/slice', [Search::class, 'slice'])->name($prefix . '_search.slice');
                }
            );

        });
}
