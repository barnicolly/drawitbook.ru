<?php

namespace App\Containers\Image\Data\Factories;

use App\Containers\Image\Models\ImageEntitiesModel;
use App\Containers\Image\Models\ImagesModel;
use App\Containers\Picture\Models\PictureModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * @extends Factory<ImageEntitiesModel>
 */
class ImageEntitiesModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<ImageEntitiesModel>
     */
    protected $model = ImageEntitiesModel::class;

    /**
     * Define the model's default state.
     *
     * @return array{entity_id: Factory<PictureModel>, entity_type: class-string<PictureModel>}
     */
    public function definition(): array
    {
        return [
            'image_id' => ImagesModel::factory(),
            'entity_id' => PictureModel::factory(),
            'entity_type' => array_search(PictureModel::class, Relation::$morphMap, true),
        ];
    }
}
