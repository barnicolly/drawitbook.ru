<?php

namespace App\Containers\Search\Http\Requests;

use App\Ship\Parents\Requests\BaseFormRequest;

/**
 * @property int $page
 */
class SearchArtsSliceAjaxRequest extends BaseFormRequest
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
