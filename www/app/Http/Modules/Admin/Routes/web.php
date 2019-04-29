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

Route::group(
    [
        'middleware' => ['web', 'roles'],
        'prefix' => '/admin/article',
        'namespace' => 'App\Http\Modules\Admin\Controllers\Article',
        'roles' => ['Admin']
    ],
    function () {
        Route::get('/', ['uses' => 'Index@index'])->name('show_articles');
        Route::get('/create', ['uses' => 'Index@index'])->name('create_article');
        Route::get('/edit/{id}', ['uses' => 'Index@index'])->name('edit_article');
    });