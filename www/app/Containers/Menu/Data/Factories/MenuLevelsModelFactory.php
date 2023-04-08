<?php

namespace App\Containers\Menu\Data\Factories;

use App\Containers\Menu\Enums\MenuLevelsColumnsEnum;
use App\Containers\Menu\Models\MenuLevelsModel;
use App\Containers\Tag\Models\SprTagsModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\ArrayShape;

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
     * @return array<string, mixed>
     */
    #[ArrayShape([
        MenuLevelsColumnsEnum::CUSTOM_NAME_EN => "string",
        MenuLevelsColumnsEnum::CUSTOM_NAME_RU => "string",
        MenuLevelsColumnsEnum::SPR_TAG_ID => "int|null",
        MenuLevelsColumnsEnum::PARENT_LEVEL_ID => "int|null",
        MenuLevelsColumnsEnum::COLUMN => "int|null",
        MenuLevelsColumnsEnum::SHOW_EN => "int",
        MenuLevelsColumnsEnum::SHOW_RU => "int",
    ])]
    public function definition(): array
    {
        return [
            MenuLevelsColumnsEnum::CUSTOM_NAME_EN => null,
            MenuLevelsColumnsEnum::CUSTOM_NAME_RU => null,
            MenuLevelsColumnsEnum::SHOW_EN => 1,
            MenuLevelsColumnsEnum::SHOW_RU => 1,
            MenuLevelsColumnsEnum::SPR_TAG_ID => SprTagsModel::factory(),
            MenuLevelsColumnsEnum::PARENT_LEVEL_ID => 0,
            MenuLevelsColumnsEnum::COLUMN => null,
        ];
    }
}

