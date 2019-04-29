<?php

namespace App\Http\Modules\Admin\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Libraries\Template;
use Validator;
use App\Http\Modules\Database\Models\Common\Article\ArticleModel;

class Index extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {
        $template = new Template();

        $articles = ArticleModel::get();
        $viewData['articles'] = $articles;
        return $template->loadView('Admin::article.index', $viewData);
    }

    public function create()
    {
        $template = new Template();
        $viewData = [];
        return $template->loadView('Admin::article.show.index', $viewData);
    }

    public function edit($id)
    {
        $id = (int) $id;
        $article = ArticleModel::with(['pictures' => function ($q) {
            $q->orderBy('pivot_sort_id', 'asc');
        }])->findOrFail($id);

        $template = new Template();
        $viewData['article'] = $article;
        return $template->loadView('Admin::article.show.index', $viewData);
    }

}
