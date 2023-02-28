<?php

namespace App\Containers\Picture\Data\Dto;

use App\Ship\Parents\Dto\Dto;

class ArtDto extends Dto
{

    public int $id;

    public ?string $alt;

    public ?array $flags;

    /**
     * @var PictureFilesDto|null $images
     */
    public ?PictureFilesDto $images;

//    /**
//     * @var Collection<TagDto>|null $tags
//     */
//    public ?Collection $tags;

    public ?array $tags;
}
