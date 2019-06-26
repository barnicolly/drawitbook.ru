<?php

namespace App\Http\Modules\Content\Controllers\Open\Article;

use App\Http\Controllers\Controller;
use App\Libraries\Template;
use Illuminate\Support\Facades\Cache;
use MetaTag;
//use Validator;
use App\Http\Modules\Content\Controllers\Search;

use App\Http\Modules\Database\Models\Common\Article\ArticleModel;

class Article extends Controller
{

    public function show(string $url)
    {
        $template = new Template();
        $article = Cache::remember('article.' . $url, 60*60, function () use ($url) {
            return ArticleModel::with(['pictures' => function ($q) {
                $q->orderBy('pivot_sort_id', 'asc');
            }])->where('link', '=', $url)->where('is_show', '=', 1)->first();
        });
        if (!$article) {
            abort(404);
        }
        $search = new Search();
        $article->pictures = $search->checkExistArts($article->pictures);
        $viewData['articleBody'] = Cache::remember('article.body.' . $url, 60*60, function () use ($article) {
            $artList = view('Open::article.show.art_list', ['article' => $article])->render();
            $article->template = str_ireplace('$artList$', $artList, $article->template);
            return view('Open::article.show.article_body', ['article' => $article])->render();
        });
        $viewData['article'] = $article;
        $firstPicture = $article->pictures->first();
        MetaTag::set('title', $article->title);
        MetaTag::set('description', $article->description);
        MetaTag::set('keywords', $article->key_words);
        MetaTag::set('image', asset('arts/' . $firstPicture->path));
        return $template->loadView('Open::article.show.index', $viewData);
    }

}
