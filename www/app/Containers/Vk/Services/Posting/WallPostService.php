<?php

namespace App\Containers\Vk\Services\Posting;

use App\Containers\Picture\Services\ArtsService;
use App\Containers\Picture\Tasks\Picture\GetPictureIdForPostingTask;
use App\Containers\Tag\Services\TagsService;
use App\Containers\Vk\Services\Posting\Strategy\Wall\VkWallPostingStrategy;

class WallPostService
{
    private $artsService;
    private $tagsService;

    private GetPictureIdForPostingTask $getPictureIdForPostingTask;

    public function __construct()
    {
        $this->artsService = (new ArtsService());
        $this->tagsService = (new TagsService());
        $this->getPictureIdForPostingTask = app(GetPictureIdForPostingTask::class);
    }

    public function broadcast()
    {
        $artIdForPosting = $this->getPictureIdForPostingTask->run();
        if (!$artIdForPosting) {
            throw new \Exception('Не найден id изображения для постинга');
        }
        $art = $this->artsService->getById($artIdForPosting);
        $tags = $this->tagsService->getNamesWithoutHiddenVkByArtId($artIdForPosting);
        $artFsPath = $art['images']['primary']['fs_path'];
        $postingStrategy = new VkWallPostingStrategy($artIdForPosting, $tags, $artFsPath);
        $postingStrategy->post();
    }

}

