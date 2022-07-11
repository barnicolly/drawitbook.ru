<?php

namespace App\Ship\Dto;

use App\Containers\Seo\Dto\ShareImageDto;
use App\Ship\Parents\Dto\Dto;

class PageMetaDto extends Dto
{
    public string $title;

    public ?string $description;

    public ?ShareImageDto $shareImage;
}
