<?php

declare(strict_types=1);

namespace App\Containers\Authentication\Http\Controllers;

use App\Ship\Parents\Controllers\Auth\LoginHttpController as parentLoginController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class LoginController extends parentLoginController
{
    public function showLoginForm(): View|Factory|\Illuminate\View\View|Application
    {
        return view('auth.login', []);
    }

    public function dump(): RedirectResponse
    {
        return redirect()->route('login');
    }
}
