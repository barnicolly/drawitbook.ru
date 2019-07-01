<?php

Route::group(
    [
        'middleware' => ['web', 'roles'],
        'prefix' => '/admin',
        'namespace' => 'App\Http\Modules\Admin\Controllers\Moderate',
        'roles' => ['Admin']
    ],
    function () {
        Route::get('/moderate', ['uses' => 'Index@index'])->name('moderate');
        Route::post('/moderate/delete_image', ['uses' => 'DeleteImage@deleteImage']);
        Route::post('/moderate/delete_images', ['uses' => 'DeleteImage@deleteImages']);
        Route::post('/moderate/save_image', ['uses' => 'SaveImage@saveImage']);
    });

Route::group(
    [
        'middleware' => ['web', 'roles'],
        'prefix' => '/admin/art',
        'namespace' => 'App\Http\Modules\Admin\Controllers\Art',
        'roles' => ['Admin']
    ],
    function () {
        Route::post('/setVkPostingOn', ['uses' => 'Art@setVkPostingOnRequest']);
        Route::post('/setVkPostingOff', ['uses' => 'Art@setVkPostingOffRequest']);
        Route::get('/{id}/getSettingsModal', ['uses' => 'Art@getSettingsModal']);
        Route::post('/{id}/postInVkAlbum', ['uses' => 'Art@postInVkAlbum']);
        Route::post('/{id}/removeFromVkAlbum', ['uses' => 'Art@removeFromVkAlbum']);
    });

