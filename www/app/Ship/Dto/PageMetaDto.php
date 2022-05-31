<?php

namespace App\Ship\Dto;

use Spatie\DataTransferObject\DataTransferObject;

class PageMetaDto extends DataTransferObject
{
    public string $title;

    public ?string $description;

    public ?string $shareImage;
}
