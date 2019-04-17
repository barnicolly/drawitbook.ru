<?php

namespace App\Http\Modules\Content\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Database\Models\Common\Picture\PictureModel;
use App\Libraries\Template;

class Content extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {
        $template = new Template();
        $pictures = PictureModel::take(20)->with(['tags'])->get();

        $viewData['pictures'] = $pictures;
        return $template->loadView('Content::index', $viewData);
    }

}
