<?php

namespace App\Containers\Picture\Http\Requests\Art;

use App\Containers\Claim\Data\Rules\ReasonIdRule;
use App\Containers\Picture\Enums\PictureColumnsEnum;
use App\Ship\Parents\Requests\BaseFormRequest;

/**
 * @property int $id
 * @property int $reason
 */
class ClaimAjaxRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['id' => $this->route('id')]);
    }

    public function rules(): array
    {
        $pictureTable = PictureColumnsEnum::TABlE;
        return [
            'id' => "required|integer|exists:{$pictureTable},id",
            'reason' => [
                'required',
                new ReasonIdRule(),
            ],
        ];
    }

    public function filters(): array
    {
        return [];
    }


}
