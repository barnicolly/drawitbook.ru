<?php

namespace App\Containers\Claim\Data\Factories;

use App\Containers\Claim\Enums\SprClaimReasonColumnsEnum;
use App\Containers\Claim\Models\SprClaimReasonModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class SprClaimReasonModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SprClaimReasonModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    #[ArrayShape([SprClaimReasonColumnsEnum::REASON => "string"])]
    public function definition(): array
    {
        return [
            SprClaimReasonColumnsEnum::REASON => $this->faker->text(25),
        ];
    }
}

