<?php

declare(strict_types=1);

namespace App\Containers\Search\Http\Requests;

use App\Ship\Parents\Requests\BaseFormRequest;

/**
 * @property int $page
 * @property string $query
 */
final class SearchArtsSliceAjaxRequest extends BaseFormRequest
{
    protected array $casts = [
        'page' => 'int',
        'query' => 'string',
    ];

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
