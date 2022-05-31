<?php

namespace App\Containers\Seo\Dto;

use Spatie\DataTransferObject\DataTransferObject;

class BreadcrumbDto extends DataTransferObject
{
    public string $title;

    public ?string $url;
}
