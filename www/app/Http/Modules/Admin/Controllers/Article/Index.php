<?php

namespace App\Http\Modules\Admin\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Http\Modules\Content\Controllers\Search;
use App\Libraries\Template;
use Validator;
use App\Entities\Article\ArticleModel;

class Index extends Controller
{

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

    public function preview($id)
    {
        $template = new Template();
        $article = ArticleModel::with(['pictures' => function ($q) {
            $q->orderBy('pivot_sort_id', 'asc');
        }])->findOrFail($id);

        $search = new Search();
        $article->pictures = $search->checkExistArts($article->pictures);

        $artList = view('Open::article.show.art_list', ['article' => $article])->render();
        $article->template = str_ireplace('$artList$', $artList, $article->template);
        $viewData['article'] = $article;
        return $template->loadView('Open::article.show.index', $viewData);
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
