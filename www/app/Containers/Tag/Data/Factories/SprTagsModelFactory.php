<?php

namespace App\Containers\Tag\Data\Factories;

use App\Containers\Tag\Enums\SprTagsColumnsEnum;
use App\Containers\Tag\Models\SprTagsModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;

class SprTagsModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SprTagsModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    #[ArrayShape([
        SprTagsColumnsEnum::NAME => "string",
        SprTagsColumnsEnum::NAME_EN => "string",
        SprTagsColumnsEnum::HIDDEN => "int",
        SprTagsColumnsEnum::HIDDEN_VK => "int",
        SprTagsColumnsEnum::SEO => "string",
        SprTagsColumnsEnum::SLUG_EN => "string",
    ])]
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
        ];
    }
}

