<?php

Route::group(
    [
        'middleware' => ['web', 'roles'],
        'prefix' => '/admin',
        'namespace' => 'App\Http\Modules\Admin\Controllers\Moderate',
        'roles' => ['Admin']
    ],
    function () {
        Route::get('/moderate', ['uses' => 'Index@index']);
        Route::post('/moderate/delete_image', ['uses' => 'DeleteImage@deleteImage']);
        Route::post('/moderate/delete_images', ['uses' => 'DeleteImage@deleteImages']);
        Route::post('/moderate/save_image', ['uses' => 'SaveImage@saveImage']);
    });