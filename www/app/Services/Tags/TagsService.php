<?php

namespace App\Services\Tags;

use App\Entities\Picture\PictureModel;

class TagsService
{

    public function __construct()
    {

    }

    public function extractTagsFromArt(PictureModel $art): array
    {
        $tags = [];
        foreach ($art->tags as $tag) {
            if ($tag->hidden === 0) {
                $tags[] = mbUcfirst($tag->name);
            }
        }
        return $tags;
    }

}

