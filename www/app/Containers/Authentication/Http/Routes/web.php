<?php

use App\Containers\Authentication\Http\Controllers\LoginController;

Route::group(
    [
        'middleware' => 'web',
        'prefix' => '/',
    ],
    static function (): void {
        Route::get('/ru/login', (new LoginController())->showLoginForm(...))->name('loginPage');
        Route::post('/ru/login', (new LoginController())->login(...))->name('login');
        Route::get('/register', (new LoginController())->dump(...));
        Route::post('/register', (new LoginController())->dump(...));
        Route::get('/password/reset', (new LoginController())->dump(...));
        Route::post('password/email', (new LoginController())->dump(...));
        Route::get('password/reset/{token}', (new LoginController())->dump(...));
        Route::post('password/reset', (new LoginController())->dump(...));
        Route::get('/logout', (new LoginController())->logout(...));
    }
);
