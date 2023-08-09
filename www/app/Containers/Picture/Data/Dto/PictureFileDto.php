<?php

declare(strict_types=1);

namespace App\Containers\Picture\Data\Dto;

use App\Containers\Image\Models\ImagesModel;
use App\Ship\Parents\Dto\Dto;

final class PictureFileDto extends Dto
{
    public int $width;

    public int $height;

    public string $path;

    public string $relative_path;

    public string $mime_type;

    public string $url;

    public static function fromModel(ImagesModel $file): self
    {
        return new self(
            path: $file->path,
            url: formArtFsPath($file->path),
            relative_path: getArtsFolder() . $file->path,
            height: $file->id,
            width: $file->id,
            mime_type: $file->mime_type,
        );
    }
}
