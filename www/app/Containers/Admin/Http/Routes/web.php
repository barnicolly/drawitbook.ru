<?php

use App\Containers\Admin\Http\Controllers\ArtHttpController;

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
                    Route::post('/setVkPostingOn', [ArtHttpController::class, 'setVkPostingOnRequest']);
                    Route::post('/setVkPostingOff', [ArtHttpController::class, 'setVkPostingOffRequest']);
                    Route::get('/{id}/getSettingsModal', [ArtHttpController::class, 'getSettingsModal']);
                    Route::post('/{id}/postInVkAlbum', [ArtHttpController::class, 'postInVkAlbum']);
                    Route::post('/{id}/removeFromVkAlbum', [ArtHttpController::class, 'removeFromVkAlbum']);
                }
            );
        }
    );
}

