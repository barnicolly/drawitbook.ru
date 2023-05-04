<?php

namespace App\Containers\Picture\Tests\Traits;

use App\Containers\Picture\Enums\PictureExtensionsColumnsEnum;
use App\Containers\Picture\Enums\PictureTagsColumnsEnum;
use App\Containers\Picture\Models\PictureExtensionsModel;
use App\Containers\Picture\Models\PictureModel;
use App\Containers\Picture\Models\PictureTagsModel;
use App\Containers\Tag\Models\SprTagsModel;

trait CreatePictureWithRelationsTrait
{
    /**
     * @return array{PictureModel, PictureExtensionsModel}
     */
    public function createPictureWithFile(): array
    {
        $picture = $this->createPicture();
        $file = $this->createPictureFile($picture);
        return [$picture, $file];
    }

    public function createPicture(array $data = []): PictureModel
    {
        return PictureModel::factory()->create($data);
    }

    public function createPictureFile(PictureModel $picture): PictureExtensionsModel
    {
        return PictureExtensionsModel::factory()->create(
            [
                PictureExtensionsColumnsEnum::PICTURE_ID => $picture->id,
            ]
        );
    }

    public function createPictureTag(PictureModel $picture, SprTagsModel $tag): PictureTagsModel
    {
        return PictureTagsModel::factory()->create(
            [
                PictureTagsColumnsEnum::PICTURE_ID => $picture->id,
                PictureTagsColumnsEnum::TAG_ID => $tag->id,
            ]
        );
    }
}
