<?php

declare(strict_types=1);

namespace App\Containers\Tag\Data\Dto;

use App\Ship\Parents\Dto\Dto;

class GetListPopularTagsWithCountArtsResultDto extends Dto
{
    public array $cloudItems;
}
