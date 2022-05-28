<?php

use App\Containers\Search\Http\Controllers\SearchController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

foreach (config('translator.available_locales') as $prefix) {
    Route::group(
        ['prefix' => $prefix],
        function () use ($prefix) {

                  Route::group(
                      [
                          'middleware' => 'web',
                      ],
                      function () use ($prefix) {
                          Route::get('/search', [SearchController::class, 'index'])->name($prefix . '_search');

                          Route::get('/search/slice', [SearchController::class, 'slice'])->name($prefix . '_search.slice');
                      }
                  );

        });
}