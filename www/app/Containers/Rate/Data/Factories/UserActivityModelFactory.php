<?php

namespace App\Containers\Rate\Data\Factories;

use App\Containers\Rate\Enums\RateEnum;
use App\Containers\Rate\Enums\UserActivityColumnsEnum;
use App\Containers\Rate\Models\UserActivityModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class UserActivityModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserActivityModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    #[ArrayShape([
        UserActivityColumnsEnum::PICTURE_ID => "int",
        UserActivityColumnsEnum::ACTIVITY => "int",
        UserActivityColumnsEnum::USER_ID => "int",
    ])]
    public function definition(): array
    {
        return [
            UserActivityColumnsEnum::PICTURE_ID => $this->faker->randomDigitNotNull,
            UserActivityColumnsEnum::ACTIVITY => RateEnum::LIKE,
            UserActivityColumnsEnum::USER_ID => 0,
        ];
    }
}

