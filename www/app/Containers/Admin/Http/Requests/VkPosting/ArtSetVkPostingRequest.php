<?php

namespace App\Containers\Admin\Http\Requests\VkPosting;

use App\Containers\Picture\Enums\PictureColumnsEnum;
use App\Ship\Parents\Requests\BaseFormRequest;

/**
 * @property int $id
 */
class ArtSetVkPostingRequest extends BaseFormRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $pictureTable = PictureColumnsEnum::TABlE;
        return [
            'id' => "required|integer|exists:{$pictureTable},id",
        ];
    }

    public function filters()
    {
        return [
            'id' => 'cast:integer',
        ];
    }
}
