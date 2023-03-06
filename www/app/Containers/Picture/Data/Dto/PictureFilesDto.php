<?php

namespace App\Containers\Picture\Data\Dto;

use App\Ship\Parents\Dto\Dto;

class PictureFilesDto extends Dto
{

    public PictureFileDto $primary;

    public ?PictureFileDto $optimized;
}