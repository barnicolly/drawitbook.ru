<?php

declare(strict_types=1);

namespace App\Containers\User\Data\Dto;

use App\Ship\Parents\Dto\Dto;

final class UserDto extends Dto
{
    public string $ip;

    public ?int $id = null;
}
