<?php

namespace App\Http\Modules\Content\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\Template;
use MetaTag;
//use Validator;

class Search extends Controller
{

    public function index()
    {
        $template = new Template();
//        $article = ArticleModel::where('link', '=', $url)->firstOrFail();
//        $viewData['article'] = $article;
        return $template->loadView('Content::index');
    }

}
