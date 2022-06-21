<?php

namespace App\Containers\Admin\Http\Requests\VkPosting;

use App\Containers\Picture\Enums\PictureColumnsEnum;
use App\Ship\Parents\Requests\BaseFormRequest;

/**
 * @property int $id
 */
class ArtSetVkPostingRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $pictureTable = PictureColumnsEnum::TABlE;
        return [
            'id' => "required|integer|exists:{$pictureTable},id",
        ];
    }

    public function filters(): array
    {
        return [
            'id' => 'cast:integer',
        ];
    }
}
