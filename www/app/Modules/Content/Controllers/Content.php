<?php

namespace App\Modules\Content\Controllers;

use App\Http\Controllers\Controller;

class Content extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {
        return view('Content::index');
    }

}
