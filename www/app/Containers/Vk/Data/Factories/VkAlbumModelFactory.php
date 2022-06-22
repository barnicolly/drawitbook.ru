<?php

namespace App\Containers\Vk\Data\Factories;

use App\Containers\Vk\Enums\VkAlbumColumnsEnum;
use App\Containers\Vk\Models\VkAlbumModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class VkAlbumModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = VkAlbumModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            VkAlbumColumnsEnum::ALBUM_ID => $this->faker->randomDigit(),
            VkAlbumColumnsEnum::SHARE => null,
            VkAlbumColumnsEnum::DESCRIPTION => $this->faker->text(100),
        ];
    }
}

