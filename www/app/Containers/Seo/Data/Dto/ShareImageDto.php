<?php

namespace App\Containers\Seo\Data\Dto;

use App\Ship\Parents\Dto\Dto;

class ShareImageDto extends Dto
{
    public string $relativePath;

    public int $width;

    public int $height;
}