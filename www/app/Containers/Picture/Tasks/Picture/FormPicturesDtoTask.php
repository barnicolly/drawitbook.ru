<?php

declare(strict_types=1);

namespace App\Containers\Picture\Tasks\Picture;

use App\Containers\Picture\Data\PictureDtoBuilder;
use App\Containers\Picture\Models\PictureModel;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Collection;

final class FormPicturesDtoTask extends Task
{
    public function run(Collection $arts): array
    {
        return $arts
            ->map(static fn (PictureModel $picture): array => (new PictureDtoBuilder($picture))
                ->setFiles($picture->extensions)
                ->setFlags($picture->flags)
                ->setTags($picture->tags)
                ->build()
                ->toArray())
            ->toArray();
    }
}
