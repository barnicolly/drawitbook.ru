<?php

use App\Containers\Admin\Http\Controllers\ArtController;

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
                    Route::post('/setVkPostingOn', [ArtController::class, 'setVkPostingOnRequest']);
                    Route::post('/setVkPostingOff', [ArtController::class, 'setVkPostingOffRequest']);
                    Route::get('/{id}/getSettingsModal', [ArtController::class, 'getSettingsModal']);
                    Route::post('/{id}/postInVkAlbum', [ArtController::class, 'postInVkAlbum']);
                    Route::post('/{id}/removeFromVkAlbum', [ArtController::class, 'removeFromVkAlbum']);
                }
            );
        }
    );
}

