<?php

namespace App\UseCases\Picture;

use App\Entities\Picture\PictureModel;

class GetTagsFromPicture
{

    public function __construct()
    {
    }

    public function getTagIds(PictureModel $picture): array
    {
        $hidden = [];
        $shown = [];
        foreach ($picture->tags as $tag) {
            if ($tag->hidden === 1) {
                $hidden[] = $tag->id;
            } else {
                $shown[] = $tag->id;
            }
        }
        return [$shown, $hidden];
    }

}
