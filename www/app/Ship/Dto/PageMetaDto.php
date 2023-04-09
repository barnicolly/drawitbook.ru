<?php

namespace App\Ship\Dto;

use App\Containers\Seo\Data\Dto\ShareImageDto;
use App\Ship\Parents\Dto\Dto;

class PageMetaDto extends Dto
{
    public string $title;

    public ?string $description = null;

    public ?ShareImageDto $shareImage = null;
}
