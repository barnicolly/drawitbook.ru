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
        function () use ($prefix): void {

                  Route::group(
                      [
                          'middleware' => 'web',
                      ],
                      function () use ($prefix): void {
                          Route::get('/search', (new SearchController())->index(...))->name($prefix . '_search');

                          Route::group(
                              [
                                  'middleware' => ['ajax'],
                              ],
                              function () use ($prefix): void {
                                  Route::get('/search/slice', (new SearchController())->slice(...))->name($prefix . '_search.slice');
                              });
                      }
                  );

        });
}
