<?php

namespace App\Containers\Search\Http\Requests;

use App\Ship\Parents\Requests\BaseFormRequest;

/**
 * @property int $page
 * @property string $query
 */
class SearchArtsSliceAjaxRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'query' => [
                'required',
                'string',
            ],
            'page' => [
                'required',
                'integer',
            ],
        ];
    }

    public function filters(): array
    {
        return [
            'query' => 'trim',
        ];
    }

}