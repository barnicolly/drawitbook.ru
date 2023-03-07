<?php

namespace App\Containers\Category\Data\Factories;

use App\Containers\Category\Enums\CategoryColumnsEnum;
use App\Containers\Category\Models\CategoryModel;
use App\Containers\Tag\Models\SprTagsModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class CategoryModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CategoryModel::class;

    #[ArrayShape([
        CategoryColumnsEnum::CUSTOM_NAME_EN => "string",
        CategoryColumnsEnum::CUSTOM_NAME_RU => "string",
        CategoryColumnsEnum::SPR_TAG_ID => "int|null",
        CategoryColumnsEnum::PARENT_ID => "int|null",
        CategoryColumnsEnum::SHOW_EN => "int",
        CategoryColumnsEnum::SHOW_RU => "int",
    ])]
    public function definition(): array
    {
        return [
            CategoryColumnsEnum::CUSTOM_NAME_EN => null,
            CategoryColumnsEnum::CUSTOM_NAME_RU => null,
            CategoryColumnsEnum::SHOW_EN => 1,
            CategoryColumnsEnum::SHOW_RU => 1,
            CategoryColumnsEnum::SPR_TAG_ID => SprTagsModel::factory(),
            CategoryColumnsEnum::PARENT_ID => null,
        ];
    }
}

