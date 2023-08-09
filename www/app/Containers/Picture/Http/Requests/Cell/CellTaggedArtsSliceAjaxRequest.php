<?php

declare(strict_types=1);

namespace App\Containers\Picture\Http\Requests\Cell;

use App\Ship\Parents\Requests\BaseFormRequest;

/**
 * @property int $page
 */
final class CellTaggedArtsSliceAjaxRequest extends BaseFormRequest
{

    protected array $casts = [
        'page' => 'int',
    ];

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
}
