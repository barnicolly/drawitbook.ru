<?php

namespace App\Http\Modules\Auth\Controllers;

use App\Http\Controllers\Auth\RegisterController;

class Register extends RegisterController
{

    public function showRegistrationForm()
    {
        return redirect('login');
    }
}
