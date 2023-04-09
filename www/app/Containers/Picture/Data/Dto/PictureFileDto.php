<?php

namespace App\Containers\Picture\Data\Dto;

use App\Containers\Picture\Models\PictureExtensionsModel;
use App\Ship\Parents\Dto\Dto;

class PictureFileDto extends Dto
{
    public int $width;

    public int $height;

    public string $path;

    public string $relative_path;

    public string $mime_type;

    public string $fs_path;

    public static function fromModel(PictureExtensionsModel $file): self
    {
        return new self(
            path: $file->path,
            fs_path: formArtFsPath($file->path),
            relative_path: getArtsFolder() . $file->path,
            height: $file->id,
            width: $file->id,
            mime_type: $file->mime_type,
        );
    }
}
