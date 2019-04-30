<?php

namespace App\Http\Modules\Admin\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class ArticlePictureSaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|integer',
            'picture_id' => 'required|integer',
            'article_id' => 'required|integer',
            'sort_id' => 'required|integer',
            'caption' => 'max:255',
        ];
    }

    public function filters()
    {
        return [
            'id' => 'cast:integer',
            'picture_id' => 'cast:integer',
            'article_id' => 'cast:integer',
            'sort_id' => 'cast:integer',
            'caption' => 'trim|capitalize|strip_tags',
        ];
    }
}
