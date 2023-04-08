<?php

use App\Containers\Content\Http\Controllers\ContentHttpController;

foreach (config('translator.available_locales') as $prefix) {
    Route::group(
        ['prefix' => $prefix],
        function () use ($prefix): void {
            Route::group(
                [
                    'middleware' => 'web',
                ],
                function () use ($prefix): void {
                    Route::get('/', [ContentHttpController::class, 'showMainPage'])
                        ->middleware(['lower_case', 'no_get'])
                        ->name($prefix . '_home');
                }
            );
        });
}
