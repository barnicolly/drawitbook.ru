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
        Route::get('/create', ['uses' => 'Index@create'])->name('create_article');
        Route::get('/edit/{id}', ['uses' => 'Index@edit'])->name('edit_article');
        Route::post('/save', ['uses' => 'Article@save'])->name('save_article');
    });

Route::group(
    [
        'middleware' => ['web', 'roles'],
        'prefix' => '/admin/article/',
        'namespace' => 'App\Http\Modules\Admin\Controllers\Article',
        'roles' => ['Admin']
    ],
    function () {
        Route::post('/{id}/detach/{artId}', ['uses' => 'Article_picture@detach']);
        Route::get('/getModal', ['uses' => 'Article_picture@getModal']);
        Route::get('/{id}/refreshList', ['uses' => 'Article_picture@refreshList']);
        Route::post('/pictures/save', ['uses' => 'Article_picture@save']);
    });