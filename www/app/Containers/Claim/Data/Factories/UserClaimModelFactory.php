<?php

namespace App\Containers\Claim\Data\Factories;

use App\Containers\Claim\Enums\UserClaimColumnsEnum;
use App\Containers\Claim\Models\UserClaimModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

class UserClaimModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Model>
     */
    protected $model = UserClaimModel::class;

    /**
     * Define the model's default state.
     *
     * @return array{user_id: null, picture_id: int, reason_id: int}
     */
    public function definition(): array
    {
        return [
            UserClaimColumnsEnum::USER_ID => null,
            UserClaimColumnsEnum::PICTURE_ID => $this->faker->randomDigitNotNull,
            UserClaimColumnsEnum::REASON_ID => $this->faker->randomDigitNotNull,
        ];
    }
}
