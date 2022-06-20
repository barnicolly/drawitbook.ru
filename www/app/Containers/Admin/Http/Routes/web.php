<?php

use App\Containers\Admin\Http\Controllers\ArtController;
use App\Containers\Authorization\Enums\RoleEnum;

Route::group(
    [
        'middleware' => ['web', 'roles'],
        'prefix' => '/admin/art',
        'roles' => [RoleEnum::ADMIN],
    ],
    function () {
        Route::post('/setVkPostingOn', [ArtController::class, 'setVkPostingOn'])->name('admin.posting.vk.on');
        Route::post('/setVkPostingOff', [ArtController::class, 'setVkPostingOff'])->name('admin.posting.vk.off');
        Route::get('/{id}/getSettingsModal', [ArtController::class, 'getSettingsModal']);
        Route::post('/{id}/postInVkAlbum', [ArtController::class, 'postInVkAlbum']);
        Route::post('/{id}/removeFromVkAlbum', [ArtController::class, 'removeFromVkAlbum']);
    }
);

