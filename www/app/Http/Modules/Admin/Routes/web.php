<?php

use App\Http\Modules\Admin\Controllers\Art\Art;

foreach (config('translator.available_locales') as $prefix) {
    Route::group(
        ['prefix' => $prefix],
        function () use ($prefix) {
            Route::group(
                [
                    'middleware' => ['web', 'roles'],
                    'prefix' => '/admin/art',
                    'roles' => ['Admin'],
                ],
                function () {
                    Route::post('/setVkPostingOn', [Art::class, 'setVkPostingOnRequest']);
                    Route::post('/setVkPostingOff', [Art::class, 'setVkPostingOffRequest']);
                    Route::get('/{id}/getSettingsModal', [Art::class, 'getSettingsModal']);
                    Route::post('/{id}/postInVkAlbum', [Art::class, 'postInVkAlbum']);
                    Route::post('/{id}/removeFromVkAlbum', [Art::class, 'removeFromVkAlbum']);
                }
            );
        }
    );
}

