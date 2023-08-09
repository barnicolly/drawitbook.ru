<?php

declare(strict_types=1);

namespace App\Containers\Admin\Http\Requests\Art;

use App\Containers\Picture\Enums\PictureColumnsEnum;
use App\Containers\Vk\Enums\VkAlbumColumnsEnum;
use App\Ship\Parents\Requests\BaseFormRequest;

/**
 * @property int $id
 * @property int $album_id
 */
final class DetachPictureFromAlbumRequest extends BaseFormRequest
{
    protected array $casts = [
        'id' => 'int',
        'album_id' => 'int',
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
     * @return array{id: string, album_id: string}
     */
    public function rules(): array
    {
        $pictureTable = PictureColumnsEnum::TABlE;
        $vkAlbumTable = VkAlbumColumnsEnum::TABlE;
        return [
            'id' => "required|integer|exists:{$pictureTable},id",
            'album_id' => "required|integer|exists:{$vkAlbumTable},id",
        ];
    }
}
