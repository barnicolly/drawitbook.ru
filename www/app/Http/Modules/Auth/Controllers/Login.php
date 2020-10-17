<?php

namespace App\Http\Modules\Auth\Controllers;

use App\Http\Controllers\Auth\LoginController;

class Login extends LoginController
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
