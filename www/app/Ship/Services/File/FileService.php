<?php

declare(strict_types=1);

namespace App\Ship\Services\File;

use Illuminate\Support\Str;

class FileService
{
    public function formArtUrlPath(string $picturePath): string
    {
        if (Str::contains($picturePath, '://')) {
            return $picturePath;
        }
        return asset(getArtsFolder() . $picturePath);
    }
}
