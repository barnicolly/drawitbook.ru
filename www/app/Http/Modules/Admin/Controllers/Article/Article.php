<?php

namespace App\Http\Modules\Admin\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Http\Modules\Admin\Requests\Article\ArticleSaveRequest;
use Validator;
use App\Http\Modules\Database\Models\Common\Article\ArticleModel;
use Illuminate\Support\Facades\DB;

class Article extends Controller
{

    public function save(ArticleSaveRequest $request)
    {
        $data = $request->validated();
        $defaultTransaction = DB::connection('mysql');
        try {
            $article = ArticleModel::findOrNew($data['id']);
            unset($data['id']);
            $article->title = $data['title'];
            $article->description = $data['description'];
            $article->key_words = $data['key_words'];
            $article->template = $data['template'];
            $article->link = $data['link'];
            $article->is_show = isset($data['is_show']) ? 1 : 0;
            $article->save();
            $defaultTransaction->commit();
        } catch (\Exception $e) {
            $defaultTransaction->rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
        return response(['success' => true, 'id' => $article->id]);
    }

    private function _transformValidatorMessage($validator)
    {
        return implode('<br>', $validator->errors()->all('<p>:message</p>'));
    }
}
