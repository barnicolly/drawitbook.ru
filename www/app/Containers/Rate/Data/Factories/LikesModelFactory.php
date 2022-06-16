<?php

namespace App\Containers\Rate\Data\Factories;

use App\Containers\Rate\Enums\LikesColumnsEnum;
use App\Containers\Rate\Models\LikesModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class LikesModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LikesModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    #[ArrayShape([
        LikesColumnsEnum::PICTURE_ID => "int",
        LikesColumnsEnum::USER_ID => "null|int",
    ])]
    public function definition(): array
    {
        return [
            LikesColumnsEnum::PICTURE_ID => $this->faker->randomDigitNotNull,
            LikesColumnsEnum::USER_ID => null,
        ];
    }
}

