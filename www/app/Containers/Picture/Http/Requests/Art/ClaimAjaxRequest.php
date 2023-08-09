<?php

declare(strict_types=1);

namespace App\Containers\Picture\Http\Requests\Art;

use App\Containers\Claim\Enums\SprClaimReasonColumnsEnum;
use App\Containers\Picture\Enums\PictureColumnsEnum;
use App\Ship\Parents\Requests\BaseFormRequest;

/**
 * @property int $id
 * @property int $reason
 */
final class ClaimAjaxRequest extends BaseFormRequest
{
    protected array $casts = [
        'id' => 'int',
        'reason' => 'int',
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
     * @return array{id: string, reason: string[]}
     */
    public function rules(): array
    {
        $pictureTable = PictureColumnsEnum::TABlE;
        $sprClaimReasonTable = SprClaimReasonColumnsEnum::TABlE;
        return [
            'id' => "required|integer|exists:{$pictureTable},id",
            'reason' => [
                'required',
                "exists:{$sprClaimReasonTable},id",
            ],
        ];
    }
}
