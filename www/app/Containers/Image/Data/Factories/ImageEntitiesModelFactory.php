<?php

namespace App\Containers\Image\Data\Factories;

use App\Containers\Image\Models\ImageEntitiesModel;
use App\Containers\Picture\Models\PictureModel;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'entity_id' => PictureModel::factory(),
            'entity_type' => PictureModel::class,
        ];
    }
}
