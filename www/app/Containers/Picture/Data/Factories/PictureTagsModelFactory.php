<?php

namespace App\Containers\Picture\Data\Factories;

use App\Containers\Picture\Enums\PictureTagsColumnsEnum;
use App\Containers\Picture\Models\PictureTagsModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\ArrayShape;

class PictureTagsModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Model>
     */
    protected $model = PictureTagsModel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape([
        PictureTagsColumnsEnum::PICTURE_ID => "int",
        PictureTagsColumnsEnum::TAG_ID => "int",
    ])]
    public function definition(): array
    {
        return [
            PictureTagsColumnsEnum::PICTURE_ID => $this->faker->randomDigitNotNull,
            PictureTagsColumnsEnum::TAG_ID => $this->faker->randomDigitNotNull,
        ];
    }
}

