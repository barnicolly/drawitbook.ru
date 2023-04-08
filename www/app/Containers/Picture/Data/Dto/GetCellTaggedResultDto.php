<?php

namespace App\Containers\Picture\Data\Dto;

use App\Ship\Parents\Dto\Dto;

class GetCellTaggedResultDto extends Dto
{

    public string $html;

    public ?string $countLeftArtsText = null;
}
