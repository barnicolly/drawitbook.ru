<?php

namespace App\Containers\Seo\Dto;

use App\Ship\Parents\Dto\Dto;

class BreadcrumbDto extends Dto
{
    public string $title;

    public ?string $url;
}
