<?php

namespace App\Containers\Tag\Http\Requests;

use App\Ship\Parents\Requests\BaseFormRequest;

class GetListPopularTagsWithCountArtsAjaxRequest extends BaseFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [];
    }

    public function filters()
    {
        return [];
    }
}
