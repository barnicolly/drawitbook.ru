<?php

namespace App\Http\Modules\Admin\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Libraries\Template;
use Validator;


class Index extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {
        $template = new Template();
        $viewData = [];
        return $template->loadView('Admin::article.index', $viewData);
    }

    public function create()
    {
        $template = new Template();
        $viewData = [];
        return $template->loadView('Admin::article.show', $viewData);
    }

    public function edit($id)
    {
        $template = new Template();
        $viewData = [];
        return $template->loadView('Admin::article.show', $viewData);
    }

}
