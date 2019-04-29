<?php

namespace App\Http\Modules\Admin\Controllers\Article;

use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Http\Request;
use App\Http\Modules\Database\Models\Common\Article\ArticleModel;
use Illuminate\Support\Facades\DB;

class Article extends Controller
{

    private function _stripTags(array $data, array $keys = [])
    {
        if (!empty($keys)) {
            foreach ($keys as $key) {
                if (!empty($data[$key])) {
                    $data[$key] = strip_tags($data[$key]);
                }
            }
        } else {
            $data = array_map('strip_tags', $data);
        }
        return $data;
    }

    private function _transformValidatorMessage($validator) {
        return implode('<br>', $validator->errors()->all('<p>:message</p>'));
    }

    public function save(Request $request)
    {
        $defaultTransaction = DB::connection('mysql');
        $data = $this->_stripTags($request->input(), ['title', 'description', 'key_words', 'link']);
        $validator = $this->_validate($data);
        if ($validator->fails()) {
            return ['success' => false, 'message' => $this->_transformValidatorMessage($validator)];
        }
        try {
            $article = ArticleModel::findOrNew($data['id']);
            unset($data['id']);
            $article->title = $data['title'];
            $article->description = $data['description'];
            $article->key_words = $data['key_words'];
            $article->template = $data['template'];
            $article->link = $data['link'];
            $article->save();
            $defaultTransaction->commit();
        } catch (\Exception $e) {
            $defaultTransaction->rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
        return response(['success' => true, 'id' => $article->id]);
    }

    private function _validate(array $data)
    {
        $validator = Validator::make($data, [
            'id' => 'required|integer',
            'title' => 'required|max:255',
            'description' => 'required|max:1000',
            'key_words' => 'required|max:500',
            'template' => [
                'required',
            ],
        ]);
        return $validator;
    }

}
