<?php

declare(strict_types=1);

namespace App\Containers\Tag\Data\Factories;

use App\Containers\Picture\Models\PictureModel;
use App\Containers\Tag\Enums\TagEntitiesColumnsEnum;
use App\Containers\Tag\Models\TagEntitiesModel;
use App\Containers\Tag\Models\TagsModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * @extends Factory<TagEntitiesModel>
 */
final class TagEntitiesModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TagEntitiesModel>
     */
    protected $model = TagEntitiesModel::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            TagEntitiesColumnsEnum::TAG_ID => TagsModel::factory(),
            TagEntitiesColumnsEnum::ENTITY_ID => PictureModel::factory(),
            TagEntitiesColumnsEnum::ENTITY_TYPE => array_search(PictureModel::class, Relation::$morphMap, true),
        ];
    }
}
