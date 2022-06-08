<?php

namespace App\Containers\Picture\Data\Factories;

use App\Containers\Picture\Enums\PictureExtensionsColumnsEnum;
use App\Containers\Picture\Models\PictureExtensionsModel;
use App\Ship\Enums\SoftDeleteStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class PictureExtensionsModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PictureExtensionsModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    #[ArrayShape([
        PictureExtensionsColumnsEnum::PICTURE_ID => "int",
        PictureExtensionsColumnsEnum::PATH => "string",
        PictureExtensionsColumnsEnum::WIDTH => "int",
        PictureExtensionsColumnsEnum::HEIGHT => "int",
        PictureExtensionsColumnsEnum::EXT => "string",
        PictureExtensionsColumnsEnum::IS_DEL => "int"
    ])]
    public function definition(): array
    {
        $ext = 'png';
        $imagePath = 'https://via.placeholder.com/300x600.png';
        return [
            PictureExtensionsColumnsEnum::PICTURE_ID => $this->faker->randomDigitNotNull,
            PictureExtensionsColumnsEnum::PATH => $imagePath,
            PictureExtensionsColumnsEnum::WIDTH => 300,
            PictureExtensionsColumnsEnum::HEIGHT => 600,
            PictureExtensionsColumnsEnum::EXT => $ext,
            PictureExtensionsColumnsEnum::IS_DEL => SoftDeleteStatusEnum::FALSE,
        ];
    }
}

