<?php

namespace App\Containers\Seo\Data\Dto;

use App\Ship\Parents\Dto\Dto;

class BreadcrumbDto extends Dto
{
    public string $title;

    public ?string $url = null;
}
