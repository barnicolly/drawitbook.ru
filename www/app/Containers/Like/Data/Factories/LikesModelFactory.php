<?php

declare(strict_types=1);

namespace App\Containers\Like\Data\Factories;

use App\Containers\Like\Enums\LikesColumnsEnum;
use App\Containers\Like\Models\LikesModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

final class LikesModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Model>
     */
    protected $model = LikesModel::class;

    /**
     * Define the model's default state.
     *
     * @return array{picture_id: int, user_id: null}
     */
    public function definition(): array
    {
        return [
            LikesColumnsEnum::PICTURE_ID => $this->faker->randomDigitNotNull,
            LikesColumnsEnum::USER_ID => null,
        ];
    }
}
