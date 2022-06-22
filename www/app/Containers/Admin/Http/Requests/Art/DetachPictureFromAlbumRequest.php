<?php

namespace App\Containers\Admin\Http\Requests\Art;

use App\Containers\Picture\Enums\PictureColumnsEnum;
use App\Containers\Vk\Enums\VkAlbumColumnsEnum;
use App\Ship\Parents\Requests\BaseFormRequest;

/**
 * @property int $id
 * @property int $album_id
 */
class DetachPictureFromAlbumRequest extends BaseFormRequest
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
        $vkAlbumTable = VkAlbumColumnsEnum::TABlE;
        return [
            'id' => "required|integer|exists:{$pictureTable},id",
            'album_id' => "required|integer|exists:{$vkAlbumTable},id",
        ];
    }

    public function filters(): array
    {
        return [
            'id' => 'cast:integer',
            'album_id' => 'cast:integer',
        ];
    }
}