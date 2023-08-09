<?php

declare(strict_types=1);

namespace App\Containers\Admin\Http\Requests\VkPosting;

use App\Containers\Picture\Enums\PictureColumnsEnum;
use App\Ship\Parents\Requests\BaseFormRequest;

/**
 * @property int $id
 */
final class ArtSetVkPostingRequest extends BaseFormRequest
{
    protected array $casts = [
        'id' => 'int',
    ];

    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array{id: string}
     */
    public function rules(): array
    {
        $pictureTable = PictureColumnsEnum::TABlE;
        return [
            'id' => "required|integer|exists:{$pictureTable},id",
        ];
    }
}
