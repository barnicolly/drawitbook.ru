<?php

namespace App\Ship\Dto;

use App\Ship\Parents\Dto\Dto;

class PaginationMetaDto extends Dto
{

    public int $page;

    public ?bool $isLastPage;
}
