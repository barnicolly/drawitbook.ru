<?php

use App\Containers\Content\Http\Controllers\ContentHttpController;

foreach (config('translator.available_locales') as $prefix) {
    Route::group(
        ['prefix' => $prefix],
        static function () use ($prefix): void {
            Route::group(
                [
                    'middleware' => 'web',
                ],
                static function () use ($prefix): void {
                    Route::get('/', (new ContentHttpController())->showMainPage(...))
                        ->middleware(['lower_case', 'no_get'])
                        ->name($prefix . '_home');
                }
            );
        }
    );
}
