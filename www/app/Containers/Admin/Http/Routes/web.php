<?php

use App\Containers\Admin\Http\Controllers\ArtController;
use App\Containers\Authorization\Enums\RoleEnum;

Route::group(
    [
        'middleware' => ['web', 'roles'],
        'prefix' => '/admin/art',
        'roles' => [RoleEnum::ADMIN],
    ],
    static function (): void {
        Route::post('/setVkPostingOn', (new ArtController())->setVkPostingOn(...))->name('admin.posting.vk.on');
        Route::post('/setVkPostingOff', (new ArtController())->setVkPostingOff(...))->name('admin.posting.vk.off');
        Route::get('/{id}/getSettingsModal', (new ArtController())->getSettingsModal(...))->name('admin.picture.settings');
        Route::post('/{id}/postInVkAlbum', (new ArtController())->attachPictureOnAlbum(...))->name('admin.posting.vk.album.attach');
        Route::post('/{id}/removeFromVkAlbum', (new ArtController())->detachPictureFromAlbum(...))->name('admin.posting.vk.album.detach');
    }
);
