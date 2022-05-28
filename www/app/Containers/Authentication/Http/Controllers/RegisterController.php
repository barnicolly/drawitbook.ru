<?php

namespace App\Containers\Authentication\Http\Controllers;

use App\Http\Controllers\Auth\RegisterController as parentRegisterController;

class RegisterController extends parentRegisterController
{

    public function showRegistrationForm()
    {
        return redirect('login');
    }
}
