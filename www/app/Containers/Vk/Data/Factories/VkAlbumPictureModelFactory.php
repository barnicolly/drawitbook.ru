<?php

namespace App\Containers\Vk\Data\Factories;

use App\Containers\Picture\Models\PictureModel;
use App\Containers\Vk\Enums\VkAlbumPictureColumnsEnum;
use App\Containers\Vk\Models\VkAlbumModel;
use App\Containers\Vk\Models\VkAlbumPictureModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

class VkAlbumPictureModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Model>
     */
    protected $model = VkAlbumPictureModel::class;

    /**
     * Define the model's default state.
     *
     * @return array{vk_album_id: Factory<VkAlbumModel>, out_vk_image_id: int, picture_id: Factory<PictureModel>}
     */
    public function definition(): array
    {
        return [
            VkAlbumPictureColumnsEnum::VK_ALBUM_ID => VkAlbumModel::factory(),
            VkAlbumPictureColumnsEnum::OUT_VK_IMAGE_ID => $this->faker->randomDigit(),
            VkAlbumPictureColumnsEnum::PICTURE_ID => PictureModel::factory(),
        ];
    }
}

