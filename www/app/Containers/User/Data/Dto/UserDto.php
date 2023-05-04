<?php

namespace App\Containers\User\Data\Dto;

use App\Ship\Parents\Dto\Dto;

class UserDto extends Dto
{
    public string $ip;

    public ?int $id = null;
}
