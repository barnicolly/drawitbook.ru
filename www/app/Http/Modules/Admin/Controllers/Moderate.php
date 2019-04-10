<?php

namespace App\Http\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\Template;
use App\Http\Modules\Database\Models\Moderate\PagesModel;

class Moderate extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {
        $template = new Template();
        $images = PagesModel::where('id', '=', 1)
            ->with(['queries'])
            ->get();
        return $template->loadView('Admin::moderate.index', ['images' => $images]);
    }

}
