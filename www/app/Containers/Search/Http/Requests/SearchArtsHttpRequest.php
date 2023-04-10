<?php

namespace App\Containers\Search\Http\Requests;

use App\Ship\Parents\Requests\BaseFormRequest;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;

/**
 * @property string $query
 */
class SearchArtsHttpRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array{query: string[]}
     */
    public function rules(): array
    {
        return [
            'query' => [
                'required',
                'string',
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

    protected function failedValidation(Validator $validator): void
    {
        abort(Response::HTTP_NOT_FOUND);
    }
}
