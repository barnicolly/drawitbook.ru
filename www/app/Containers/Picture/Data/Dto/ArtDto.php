<?php

namespace App\Containers\Picture\Data\Dto;

use App\Ship\Parents\Dto\Dto;

class ArtDto extends Dto
{

    public int $id;

    public string $alt;

    public array $flags;

    public array $images;

    public array $tags;
}
