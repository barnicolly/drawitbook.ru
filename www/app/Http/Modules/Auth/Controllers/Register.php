<?php

namespace App\Http\Modules\Open\Controllers\Auth;

use App\Http\Controllers\Auth\RegisterController;

class Register extends RegisterController
{

    public function showRegistrationForm()
    {
        return redirect('login');
    }
}
