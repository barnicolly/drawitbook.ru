<?php

Route::group(
    [
        'middleware' => 'web',
        'prefix' => '/admin',
        'namespace' => 'App\Http\Modules\Admin\Controllers'
    ],
    function () {
        Route::get('/moderate', ['uses' => 'Moderate@index']);
        Route::post('/moderate/delete_image', ['uses' => 'Moderate@deleteImage']);
        Route::post('/moderate/delete_images', ['uses' => 'Moderate@deleteImages']);
        Route::post('/moderate/save_image', ['uses' => 'Moderate@saveImage']);
    });