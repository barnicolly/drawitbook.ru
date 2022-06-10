<?php

namespace App\Containers\Claim\Data\Factories;

use App\Containers\Claim\Models\UserClaimModel;
use App\Containers\Tag\Enums\SprTagsColumnsEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $name = $this->faker->text(15) . '_' . uniqid('', true);
        $nameEn = $name . '_en';
        return [
            SprTagsColumnsEnum::NAME => $name,
            SprTagsColumnsEnum::NAME_EN => $nameEn,
            SprTagsColumnsEnum::HIDDEN => 0,
            SprTagsColumnsEnum::HIDDEN_VK => 0,
            SprTagsColumnsEnum::SEO => Str::slug($name),
            SprTagsColumnsEnum::SLUG_EN => Str::slug($nameEn),
            SprTagsColumnsEnum::IS_POPULAR => 0,
        ];
    }
}

