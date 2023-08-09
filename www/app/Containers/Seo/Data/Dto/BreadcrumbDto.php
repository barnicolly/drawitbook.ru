<?php

declare(strict_types=1);

namespace App\Containers\Seo\Data\Dto;

use App\Ship\Parents\Dto\Dto;

final class BreadcrumbDto extends Dto
{
    public string $title;

    public ?string $url = null;
}
