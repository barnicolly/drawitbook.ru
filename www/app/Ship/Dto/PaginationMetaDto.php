<?php

namespace App\Ship\Dto;

use Spatie\DataTransferObject\DataTransferObject;

class PaginationMetaDto extends DataTransferObject
{

    public int $page;

    public ?bool $isLastPage;
}
