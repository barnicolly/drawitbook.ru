<?php

namespace App\Containers\Picture\Tasks\Picture;

use App\Containers\Picture\Data\PictureDtoBuilder;
use App\Containers\Picture\Models\PictureModel;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Collection;

class FormPicturesDtoTask extends Task
{

    public function run(Collection $arts): array
    {
        return $arts
            ->map(function (PictureModel $picture) {
                return (new PictureDtoBuilder($picture))
                    ->setFiles($picture->extensions)
                    ->setFlags($picture->flags)
                    ->setTags($picture->tags)
                    ->build()
                    ->toArray();
            })
            ->toArray();
    }
}


