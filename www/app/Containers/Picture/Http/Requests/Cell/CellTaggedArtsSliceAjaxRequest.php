<?php

namespace App\Containers\Picture\Http\Requests\Cell;

use App\Ship\Parents\Requests\BaseFormRequest;

/**
 * @property int $page
 */
class CellTaggedArtsSliceAjaxRequest extends BaseFormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array{page: string[]}
     */
    public function rules(): array
    {
        return [
            'page' => [
                'required',
                'integer',
            ],
        ];
    }

    public function filters(): array
    {
        return [];
    }
}
