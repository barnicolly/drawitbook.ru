<?php

namespace App\Containers\Picture\Http\Requests\Cell;

use App\Ship\Parents\Requests\BaseFormRequest;

class CellTaggedArtsSliceAjaxRequest extends BaseFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'page' => [
                'required',
                'integer',
            ],
        ];
    }

    public function filters()
    {
        return [];
    }
}
