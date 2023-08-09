<?php

declare(strict_types=1);

namespace App\Containers\Admin\Data\Dto;

use App\Ship\Parents\Dto\Dto;

final class GetSettingsModalResultDto extends Dto
{
    public string $html;
}
