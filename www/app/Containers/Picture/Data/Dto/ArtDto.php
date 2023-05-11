<?php

namespace App\Containers\Picture\Data\Dto;

use App\Ship\Parents\Dto\Dto;

class ArtDto extends Dto
{
    public int $id;

    public ?string $alt = null;

    public ?array $flags;

    public ?PictureFilesDto $images = null;

    //    /**
    //     * @var Collection<TagDto>|null $tags
    //     */
    //    public ?Collection $tags;

    public ?array $tags;
}
