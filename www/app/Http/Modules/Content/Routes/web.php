<?php

foreach (config('translator.available_locales') as $prefix) {
    Route::group(
        ['prefix' => $prefix],
        function () use ($prefix) {
            Route::group(
                [
                    'middleware' => 'web',
                    'namespace' => 'App\Http\Modules\Content\Controllers',
                ],
                function () use ($prefix) {
                    Route::get('/', ['uses' => 'Content@index'])
                        ->middleware(['lower_case', 'no_get'])
                        ->name($prefix . '_home');

                    Route::get('/tag/list', ['uses' => 'Content@tagList'])
                        ->middleware(['ajax']);
                }
            );

            Route::group(
                [
                    'middleware' => 'web',
                    'namespace' => 'App\Http\Modules\Content\Controllers',
                ],
                function () use ($prefix) {
                    Route::get('/search', ['uses' => 'Search@index'])->name($prefix . '_search');

                    Route::get('/search/slice', ['uses' => 'Search@slice'])->name($prefix . '_search.slice');
                }
            );

        });
}
