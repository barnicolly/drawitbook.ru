<?php

namespace App\Http\Modules\Content\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\Template;
use MetaTag;
//use Validator;
use App\Http\Modules\Content\Controllers\Search;

use App\Http\Modules\Database\Models\Common\Article\ArticleModel;

class Article extends Controller
{

    public function show(string $url)
    {
        $template = new Template();
        $article = ArticleModel::with(['pictures' => function ($q) {
            $q->orderBy('pivot_sort_id', 'asc');
        }])->where('link', '=', $url)->where('is_show', '=', 1)->firstOrFail();

        $search = new Search();
        $article->pictures = $search->checkExistArts($article->pictures);
        $artList = view('Content::article.show.art_list', ['article' => $article])->render();
        $article->template = str_ireplace('$artList$', $artList, $article->template);
        $viewData['article'] = $article;

        $firstPicture = $article->pictures->first();
        MetaTag::set('title', $article->title);
        MetaTag::set('description', $article->description);
        MetaTag::set('keywords', $article->key_words);
        MetaTag::set('image', asset('arts/' . $firstPicture->path));
        return $template->loadView('Content::article.show.index', $viewData);
    }

}
