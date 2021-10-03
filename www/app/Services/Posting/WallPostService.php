<?php

namespace App\Services\Posting;

use App\Services\Arts\ArtsService;
use App\Services\Posting\Strategy\Wall\VkWallPostingStrategy;
use App\Services\Tags\TagsService;

class WallPostService
{
    private $artsService;
    private $tagsService;

    public function __construct()
    {
        $this->artsService = (new ArtsService());
        $this->tagsService = (new TagsService());
    }

    public function broadcast()
    {
        $artIdForPosting = $this->artsService->getIdForPost();
        if (!$artIdForPosting) {
            throw new \Exception('Не найден id изображения для постинга');
        }
        $art = $this->artsService->getById($artIdForPosting);
        if (!$art) {
            throw new \Exception('Не найдено изображения для постинга');
        }
        $tags = $this->tagsService->getNamesWithoutHiddenVkByArtId($artIdForPosting);
        $artFsPath = $art['images']['primary']['fs_path'];
        $postingStrategy = new VkWallPostingStrategy($artIdForPosting, $tags, $artFsPath);
        $postingStrategy->post();
    }

}

