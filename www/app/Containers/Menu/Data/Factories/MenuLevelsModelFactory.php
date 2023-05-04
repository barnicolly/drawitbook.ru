<?php

namespace App\Containers\Menu\Data\Factories;

use App\Containers\Tag\Data\Factories\TagsModelFactory;
use App\Containers\Menu\Enums\MenuLevelsColumnsEnum;
use App\Containers\Menu\Models\MenuLevelsModel;
use App\Containers\Tag\Models\TagsModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

class MenuLevelsModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Model>
     */
    protected $model = MenuLevelsModel::class;

    /**
     * Define the model's default state.
     *
     * @return array{custom_name_en: null, custom_name_ru: null, show_en: int, show_ru: int, spr_tag_id: TagsModelFactory, parent_level_id: int, column: null}
     */
    public function definition(): array
    {
        return [
            MenuLevelsColumnsEnum::CUSTOM_NAME_EN => null,
            MenuLevelsColumnsEnum::CUSTOM_NAME_RU => null,
            MenuLevelsColumnsEnum::SHOW_EN => 1,
            MenuLevelsColumnsEnum::SHOW_RU => 1,
            MenuLevelsColumnsEnum::SPR_TAG_ID => TagsModel::factory(),
            MenuLevelsColumnsEnum::PARENT_LEVEL_ID => 0,
            MenuLevelsColumnsEnum::COLUMN => null,
        ];
    }
}
