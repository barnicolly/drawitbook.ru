<?php

use App\Containers\Tag\Http\Controllers\TagAjaxController;

foreach (config('translator.available_locales') as $prefix) {
    Route::group(
        [
            'prefix' => $prefix,
            'middleware' => ['web', 'ajax'],
        ],
        function (): void {
            Route::get('/tag/list', (new TagAjaxController())->getListPopularTagsWithCountArts(...));
        }
    );
}
