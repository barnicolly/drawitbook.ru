<?php

namespace App\Http\Modules\Admin\Requests\Article;

use App\Http\Requests\BaseFormRequest;

class ArticleSaveRequest extends BaseFormRequest
{
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
            'title' => 'required|max:255',
            'description' => 'required|max:1000',
            'key_words' => 'required|max:500',
            'is_show' => 'max:2',
            'link' => 'required|max:255',
            'template' => 'required',
        ];
    }

    public function filters()
    {
        return [
            'id' => 'cast:integer',
            'title' => 'trim|capitalize|escape|strip_tags',
            'description' => 'trim|capitalize|strip_tags',
            'key_words' => 'trim|escape|strip_tags',
            'link' => 'trim|strip_tags',
            'is_show' => 'cast:boolean|strip_tags',
            'template' => 'trim'
        ];
    }
}
