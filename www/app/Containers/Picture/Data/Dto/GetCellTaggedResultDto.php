<?php

declare(strict_types=1);

namespace App\Containers\Picture\Data\Dto;

use App\Ship\Parents\Dto\Dto;

final class GetCellTaggedResultDto extends Dto
{
    public string $html;

    public ?string $countLeftArtsText = null;
}
