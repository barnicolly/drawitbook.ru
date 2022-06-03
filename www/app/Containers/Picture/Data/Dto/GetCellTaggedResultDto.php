<?php

namespace App\Containers\Picture\Data\Dto;

use Spatie\DataTransferObject\DataTransferObject;

class GetCellTaggedResultDto extends DataTransferObject
{

    public string $html;

    public ?string $countLeftArtsText;
}
