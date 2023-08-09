<?php

declare(strict_types=1);

namespace App\Containers\Authentication\Http\Controllers;

use App\Ship\Parents\Controllers\Auth\RegisterHttpController as parentRegisterController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class RegisterController extends parentRegisterController
{
    public function showRegistrationForm(): Redirector|View|RedirectResponse|Application
    {
        return redirect('login');
    }
}
