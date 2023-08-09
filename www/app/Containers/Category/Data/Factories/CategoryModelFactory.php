<?php

declare(strict_types=1);

namespace App\Containers\Category\Data\Factories;

use App\Containers\Tag\Data\Factories\TagsModelFactory;
use App\Containers\Category\Enums\CategoryColumnsEnum;
use App\Containers\Category\Models\CategoryModel;
use App\Containers\Tag\Models\TagsModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

class CategoryModelFactory extends Factory
{
    /**
     * @var class-string<Model>
     */
    protected $model = CategoryModel::class;

    /**
     * @return array{custom_name_en: null, custom_name_ru: null, spr_tag_id: TagsModelFactory, parent_id: null}
     */
    public function definition(): array
    {
        return [
            CategoryColumnsEnum::CUSTOM_NAME_EN => null,
            CategoryColumnsEnum::CUSTOM_NAME_RU => null,
            CategoryColumnsEnum::SPR_TAG_ID => TagsModel::factory(),
            CategoryColumnsEnum::PARENT_ID => null,
        ];
    }
}
