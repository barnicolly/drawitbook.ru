<?php

namespace App\Containers\Picture\Tests\Traits;

use App\Containers\Image\Enums\ImageEntitiesColumnsEnum;
use App\Containers\Image\Models\ImageEntitiesModel;
use App\Containers\Image\Models\ImagesModel;
use App\Containers\Picture\Enums\PictureTagsColumnsEnum;
use App\Containers\Picture\Models\PictureModel;
use App\Containers\Picture\Models\PictureTagsModel;
use App\Containers\Tag\Models\TagsModel;

trait CreatePictureWithRelationsTrait
{
    /**
     * @return array{PictureModel, ImagesModel}
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

    public function createPictureFile(PictureModel $picture): ImagesModel
    {
        $imageEntity = ImageEntitiesModel::factory()->create(
            [
                ImageEntitiesColumnsEnum::ENTITY_TYPE => $picture->getMorphClass(),
                ImageEntitiesColumnsEnum::ENTITY_ID => $picture->id,
            ]
        );
        return $imageEntity->image;
    }

    public function createPictureTag(PictureModel $picture, TagsModel $tag): PictureTagsModel
    {
        return PictureTagsModel::factory()->create(
            [
                PictureTagsColumnsEnum::PICTURE_ID => $picture->id,
                PictureTagsColumnsEnum::TAG_ID => $tag->id,
            ]
        );
    }
}
