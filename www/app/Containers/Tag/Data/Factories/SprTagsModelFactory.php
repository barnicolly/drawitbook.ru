<?php

namespace App\Containers\Tag\Data\Factories;

use App\Containers\Tag\Enums\SprTagsColumnsEnum;
use App\Containers\Tag\Models\SprTagsModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;

class SprTagsModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Model>
     */
    protected $model = SprTagsModel::class;

    /**
     * Define the model's default state.
     *
     * @return array{name: string, name_en: string, seo: string, slug_en: string}
     */
    #[ArrayShape([
        SprTagsColumnsEnum::NAME => "string",
        SprTagsColumnsEnum::NAME_EN => "string",
        SprTagsColumnsEnum::SEO => "string",
        SprTagsColumnsEnum::SLUG_EN => "string",
    ])]
    public function definition(): array
    {
        $name = $this->faker->unique()->text(15);
        $nameEn = $name . '_en';
        return [
            SprTagsColumnsEnum::NAME => $name,
            SprTagsColumnsEnum::NAME_EN => $nameEn,
            SprTagsColumnsEnum::SEO => Str::slug($name),
            SprTagsColumnsEnum::SLUG_EN => Str::slug($nameEn),
        ];
    }
}

