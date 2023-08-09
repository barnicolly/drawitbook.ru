<?php

declare(strict_types=1);

namespace App\Containers\Image\Data\Factories;

use App\Containers\Image\Enums\ImageEntitiesColumnsEnum;
use App\Containers\Image\Models\ImageEntitiesModel;
use App\Containers\Image\Models\ImagesModel;
use App\Containers\Picture\Models\PictureModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * @extends Factory<ImageEntitiesModel>
 */
final class ImageEntitiesModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<ImageEntitiesModel>
     */
    protected $model = ImageEntitiesModel::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            ImageEntitiesColumnsEnum::IMAGE_ID => ImagesModel::factory(),
            ImageEntitiesColumnsEnum::ENTITY_ID => PictureModel::factory(),
            ImageEntitiesColumnsEnum::ENTITY_TYPE => array_search(PictureModel::class, Relation::$morphMap, true),
        ];
    }
}
