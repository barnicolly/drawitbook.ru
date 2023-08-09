<?php

declare(strict_types=1);

namespace App\Containers\Search\Data\Dto;

use App\Ship\Parents\Dto\Dto;

class GetAutocompleteTagsResultDto extends Dto
{
    public array $items;
}
