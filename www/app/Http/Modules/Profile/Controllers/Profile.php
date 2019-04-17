<?php

namespace App\Http\Modules\Profile\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\Template;
use Validator;

class Profile extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {
        $template = new Template();
        return $template->loadView('Profile::index', []);
    }

}