<?php

namespace App\Http\Modules\Content\Controllers;

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
