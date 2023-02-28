<?php

namespace App\Containers\Picture\Data\Dto;

use App\Ship\Parents\Dto\Dto;

class PictureFileDto extends Dto
{

    public int $width;

    public int $height;

    public string $path;

    public string $mime_type;

    public string $fs_path;
}
