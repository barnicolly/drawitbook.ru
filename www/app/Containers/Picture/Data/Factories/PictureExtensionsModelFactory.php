<?php

namespace App\Containers\Picture\Data\Factories;

use App\Containers\Picture\Enums\PictureExtensionsColumnsEnum;
use App\Containers\Picture\Models\PictureExtensionsModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @extends Factory<PictureExtensionsModel>
 */
class PictureExtensionsModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<PictureExtensionsModel>
     */
    protected $model = PictureExtensionsModel::class;

    /**
     * Define the model's default state.
     *
     * @return array{picture_id: int, path: string, width: int, height: int, ext: string, mime_type: string}
     */
    #[ArrayShape([
        PictureExtensionsColumnsEnum::PICTURE_ID => "int",
        PictureExtensionsColumnsEnum::PATH => "string",
        PictureExtensionsColumnsEnum::WIDTH => "int",
        PictureExtensionsColumnsEnum::HEIGHT => "int",
        PictureExtensionsColumnsEnum::EXT => "string",
        PictureExtensionsColumnsEnum::MIME_TYPE => "string",
    ])]
    public function definition(): array
    {
        $width = $this->faker->randomDigitNotZero();
        $height = $this->faker->randomDigitNotZero();
        $ext = 'png';
        $mimeType = 'image/png';
        $imagePath = "https://via.placeholder.com/{$width}x{$height}.png";
        return [
            PictureExtensionsColumnsEnum::PICTURE_ID => $this->faker->randomDigitNotNull,
            PictureExtensionsColumnsEnum::PATH => $imagePath,
            PictureExtensionsColumnsEnum::WIDTH => $width,
            PictureExtensionsColumnsEnum::HEIGHT => $height,
            PictureExtensionsColumnsEnum::EXT => $ext,
            PictureExtensionsColumnsEnum::MIME_TYPE => $mimeType,
        ];
    }
}

