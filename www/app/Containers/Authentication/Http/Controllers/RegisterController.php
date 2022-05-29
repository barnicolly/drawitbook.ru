<?php

namespace App\Containers\Authentication\Http\Controllers;

use App\Ship\Parents\Controllers\Auth\RegisterHttpController as parentRegisterController;

class RegisterController extends parentRegisterController
{

    public function showRegistrationForm()
    {
        return redirect('login');
    }
}
