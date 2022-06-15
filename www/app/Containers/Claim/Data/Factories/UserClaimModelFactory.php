<?php

namespace App\Containers\Claim\Data\Factories;

use App\Containers\Claim\Enums\UserClaimColumnsEnum;
use App\Containers\Claim\Models\UserClaimModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserClaimModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserClaimModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        //            todo-misha сделать user_id nullable в таблицах user_claim и user_activity и провести миграцию;
        return [
            UserClaimColumnsEnum::USER_ID => null,
            UserClaimColumnsEnum::PICTURE_ID => $this->faker->randomDigitNotNull,
            UserClaimColumnsEnum::REASON_ID => $this->faker->randomDigitNotNull,
        ];
    }
}

