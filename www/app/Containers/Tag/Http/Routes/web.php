<?php

declare(strict_types=1);

use App\Containers\Tag\Http\Controllers\TagAjaxController;
foreach (config('translator.available_locales') as $prefix) {
    Route::group(
        [
            'prefix' => $prefix,
            'middleware' => ['web', 'ajax'],
        ],
        static function (): void {
            Route::get('/tag/list', (new TagAjaxController())->getListPopularTagsWithCountArts(...));
        },
    );
}
