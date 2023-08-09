<?php

declare(strict_types=1);

namespace App\Containers\Image\Data\Factories;

use App\Containers\Image\Enums\ImagesColumnsEnum;
use App\Containers\Image\Models\ImagesModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ImagesModel>
 */
class ImagesModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<ImagesModel>
     */
    protected $model = ImagesModel::class;

    /**
     * Define the model's default state.
     *
     * @return array{path: string, width: int, height: int, ext: string, mime_type: string}
     */
    public function definition(): array
    {
        $width = $this->faker->randomDigitNotZero();
        $height = $this->faker->randomDigitNotZero();
        $ext = 'png';
        $mimeType = 'image/png';
        $imagePath = "https://via.placeholder.com/{$width}x{$height}.png";
        return [
            ImagesColumnsEnum::PATH => $imagePath,
            ImagesColumnsEnum::WIDTH => $width,
            ImagesColumnsEnum::HEIGHT => $height,
            ImagesColumnsEnum::EXT => $ext,
            ImagesColumnsEnum::MIME_TYPE => $mimeType,
        ];
    }
}
