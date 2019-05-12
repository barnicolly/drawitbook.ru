<?php

namespace App\Http\Modules\Auth\Controllers;

use App\Libraries\Template;
use App\Http\Controllers\Auth\LoginController;

class Login extends LoginController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function showLoginForm()
    {
        $template = new Template();
        return $template->loadView('Auth.login', []);
    }
}
