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

    /**
     * @return array{query: string[], page: string[]}
     */
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

    /**
     * @return array{query: string}
     */
    public function filters(): array
    {
        return [
            'query' => 'trim',
        ];
    }

}
