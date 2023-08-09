<?php

declare(strict_types=1);

namespace App\Containers\Menu\Data\Factories;

use App\Containers\Menu\Enums\MenuLevelsColumnsEnum;
use App\Containers\Menu\Models\MenuLevelsModel;
use App\Containers\Tag\Models\TagsModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

final class MenuLevelsModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Model>
     */
    protected $model = MenuLevelsModel::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            MenuLevelsColumnsEnum::CUSTOM_NAME_EN => null,
            MenuLevelsColumnsEnum::CUSTOM_NAME_RU => null,
            MenuLevelsColumnsEnum::SHOW_EN => 1,
            MenuLevelsColumnsEnum::SHOW_RU => 1,
            MenuLevelsColumnsEnum::SPR_TAG_ID => TagsModel::factory(),
            MenuLevelsColumnsEnum::PARENT_LEVEL_ID => null,
            MenuLevelsColumnsEnum::COLUMN => null,
        ];
    }
}
