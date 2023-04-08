<?php

namespace App\Containers\Picture\Data\Factories;

use DateTimeImmutable;
use App\Containers\Picture\Enums\PictureColumnsEnum;
use App\Containers\Picture\Models\PictureModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @extends Factory<PictureModel>
 */
class PictureModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<PictureModel>
     */
    protected $model = PictureModel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape([
        PictureColumnsEnum::CREATED_AT => "string",
        PictureColumnsEnum::UPDATED_AT => "string"
    ])]
    public function definition(): array
    {
        $dateTime = (new DateTimeImmutable())->format('Y-m-d H:i:s');
        return [
            PictureColumnsEnum::CREATED_AT => $dateTime,
            PictureColumnsEnum::UPDATED_AT => $dateTime,
        ];
    }
}

