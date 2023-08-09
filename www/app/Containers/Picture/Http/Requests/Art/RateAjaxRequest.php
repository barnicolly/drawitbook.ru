<?php

declare(strict_types=1);

namespace App\Containers\Picture\Http\Requests\Art;

use Illuminate\Validation\Rules\In;
use App\Containers\Picture\Enums\PictureColumnsEnum;
use App\Ship\Parents\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

/**
 * @property int $id
 * @property string $off
 */
final class RateAjaxRequest extends BaseFormRequest
{
    protected array $casts = [
        'id' => 'int',
        'off' => 'string',
    ];

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['id' => $this->route('id')]);
    }

    /**
     * @return array{id: string, off: (In[] | string[])}
     */
    public function rules(): array
    {
        $pictureTable = PictureColumnsEnum::TABlE;
        return [
            'id' => "required|integer|exists:{$pictureTable},id",
            'off' => [
                'required',
                Rule::in(['true', 'false']),
            ],
        ];
    }
}
