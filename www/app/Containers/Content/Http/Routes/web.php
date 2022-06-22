<?php

use App\Containers\Content\Http\Controllers\ContentHttpController;

foreach (config('translator.available_locales') as $prefix) {
    Route::group(
        ['prefix' => $prefix],
        function () use ($prefix) {
            Route::group(
                [
                    'middleware' => 'web',
                ],
                function () use ($prefix) {
                    Route::get('/', [ContentHttpController::class, 'showMainPage'])
                        ->middleware(['lower_case', 'no_get'])
                        ->name($prefix . '_home');
                }
            );
        });
}
