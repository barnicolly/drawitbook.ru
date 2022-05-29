<?php

namespace App\Containers\Authentication\Http\Controllers;

use App\Ship\Parents\Controllers\Auth\LoginHttpController as parentLoginController;

class LoginController extends parentLoginController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function showLoginForm()
    {
        return view('auth.login', []);
    }

    public function dump()
    {
        return redirect()->route('login');
    }
}
