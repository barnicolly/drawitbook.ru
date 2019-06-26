<?php

namespace App\Http\Modules\Admin\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Http\Modules\Admin\Requests\Article\ArticlePictureSaveRequest;
use App\Http\Modules\Database\Models\Common\Picture\PictureModel;
use Validator;
use App\Entities\Article\ArticleModel;
use App\Http\Modules\Database\Models\Common\Article\ArticlePictureModel;
use Illuminate\Http\Request;

class Article_picture extends Controller
{

    public function detach($articleId, $pictureId)
    {
        $result = ['success' => false];
        $article = ArticleModel::find($articleId);
        if ($article === null) {
            return response($result);
        }
        $article->pictures()->detach($pictureId);
        return response(['success' => true]);
    }

    public function getModal(Request $request)
    {
        $result = ['success' => false];
        if ($request->input('id')) {
            $pivotId = (int) $request->input('id');
            $relation = ArticlePictureModel::find($pivotId);
            if ($relation === null) {
                return response($result);
            }
        } else {
            $relation = [];
        }
        $modal = view('Admin::article.show.modal', ['relation' => $relation])->render();
        return ['success' => true, 'data' => $modal];
    }

    public function save(ArticlePictureSaveRequest $request)
    {
        $result = ['success' => false];
        $data = $request->validated();
        $picture = PictureModel::find($data['picture_id']);
        if ($picture === null) {
            return response($result);
        }
        $relation = ArticlePictureModel::findOrNew($data['id']);
        $relation->picture_id = $data['picture_id'];
        $relation->article_id = $data['article_id'];
        $relation->sort_id = $data['sort_id'];
        $relation->caption = $data['caption'];
        $relation->save();
        return response(['success' => true]);
    }

    public function refreshList($articleId)
    {
        $article = ArticleModel::with(['pictures' => function ($q) {
            $q->orderBy('pivot_sort_id', 'asc');
        }])->find($articleId);
        if ($article === null) {
            return response(['success' => false]);
        }
        $articlePicturesList = view('Admin::article.show.pictures.body', ['article' => $article])->render();
        return response(['success' => true, 'data' => $articlePicturesList]);
    }

}
