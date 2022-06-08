<?php

namespace App\Containers\Picture\Data\Factories;

use App\Containers\Picture\Enums\PictureColumnsEnum;
use App\Containers\Picture\Enums\ShowOnMainPageStatusEnum;
use App\Containers\Picture\Models\PictureModel;
use App\Containers\Vk\Enums\VkPostingStatusEnum;
use App\Ship\Enums\SoftDeleteStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class PictureModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PictureModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    #[ArrayShape([
        PictureColumnsEnum::DESCRIPTION => "string",
        PictureColumnsEnum::IS_DEL => "int",
        PictureColumnsEnum::IN_COMMON => "int",
        PictureColumnsEnum::IN_VK_POSTING => "int",
        PictureColumnsEnum::CREATED_AT => "string",
        PictureColumnsEnum::UPDATED_AT => "string"
    ])]
    public function definition(): array
    {
        $dateTime = (new \DateTimeImmutable())->format('Y-m-d H:i:s');
        return [
            PictureColumnsEnum::DESCRIPTION => $this->faker->text(100),
            PictureColumnsEnum::IS_DEL => SoftDeleteStatusEnum::FALSE,
            PictureColumnsEnum::IN_COMMON => ShowOnMainPageStatusEnum::FALSE,
            PictureColumnsEnum::IN_VK_POSTING => VkPostingStatusEnum::FALSE,
            PictureColumnsEnum::CREATED_AT => $dateTime,
            PictureColumnsEnum::UPDATED_AT => $dateTime,
        ];
    }
}

