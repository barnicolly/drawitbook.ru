<?php

namespace App\Http\Modules\Admin\Controllers\Article;

use App\Http\Controllers\Controller;
use Validator;
use App\Http\Modules\Database\Models\Common\Article\ArticleModel;

class Article_picture extends Controller
{

    public function detach($articleId, $pictureId)
    {
        $result = ['success' => false];
        $article = ArticleModel::find($articleId);
        if ($article === null) {
            return response($result);
        }
//        $article->pictures()->detach($pictureId);
        return response(['success' => true]);
    }

    public function getModal()
    {
        $modal = view('Admin::article.show.modal', [])->render();

        return ['success' => true, 'data' => $modal];
    }

}
