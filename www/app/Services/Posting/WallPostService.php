<?php

namespace App\Services\Posting;

use App\Entities\Picture\PictureModel;
use App\Services\Arts\ArtsService;
use App\Services\Posting\Strategy\Wall\VkWallPostingStrategy;

class WallPostService
{
    private $artsService;

    public function __construct()
    {
        $this->artsService = (new ArtsService());
    }

    public function broadcast()
    {
        $artIdForPosting = $this->artsService->getIdForPost();
        $picture = PictureModel::with(
            [
                'tags' => function ($q) {
                    $q->where('spr_tags.hidden_vk', '=', 0);
                },
            ]
        )
            ->find($artIdForPosting);
        $tags = $picture->tags->pluck('name')->toArray();
        $path = formArtFsPath($picture->path);

        $postingStrategy = new VkWallPostingStrategy($artIdForPosting, $tags, $path);
        $postingStrategy->post();
    }

}

