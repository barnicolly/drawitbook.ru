<?php

declare(strict_types=1);

namespace App\Containers\Tag\Data\Factories;

use App\Containers\Tag\Enums\TagsColumnsEnum;
use App\Containers\Tag\Models\TagsModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

final class TagsModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Model>
     */
    protected $model = TagsModel::class;

    /**
     * Define the model's default state.
     *
     * @return array{name: string, name_en: string, seo: string, slug_en: string}
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->text(15);
        $nameEn = $name . '_en';
        return [
            TagsColumnsEnum::NAME => $name,
            TagsColumnsEnum::NAME_EN => $nameEn,
            TagsColumnsEnum::SEO => Str::slug($name),
            TagsColumnsEnum::SLUG_EN => Str::slug($nameEn),
        ];
    }
}
