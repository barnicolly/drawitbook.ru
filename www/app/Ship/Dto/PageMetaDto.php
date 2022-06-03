<?php

namespace App\Ship\Dto;

use App\Ship\Parents\Dto\Dto;

class PageMetaDto extends Dto
{
    public string $title;

    public ?string $description;

    public ?string $shareImage;
}
