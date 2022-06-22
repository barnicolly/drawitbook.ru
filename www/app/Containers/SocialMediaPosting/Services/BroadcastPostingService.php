<?php

namespace App\Containers\SocialMediaPosting\Services;

use App\Containers\Picture\Services\ArtsService;
use App\Containers\Picture\Tasks\Picture\GetPictureIdForPostingTask;
use App\Containers\SocialMediaPosting\Tasks\CreateSocialMediaPostingItemTask;
use App\Containers\Tag\Services\TagsService;
use App\Containers\Vk\Services\VkWallPostingStrategy;

class BroadcastPostingService
{

    private ArtsService $artsService;
    private TagsService $tagsService;
    private GetPictureIdForPostingTask $getPictureIdForPostingTask;
    private CreateSocialMediaPostingItemTask $createSocialMediaPostingItemTask;

    public function __construct(
        ArtsService $artsService,
        TagsService $tagsService,
        GetPictureIdForPostingTask $getPictureIdForPostingTask,
        CreateSocialMediaPostingItemTask $createSocialMediaPostingItemTask
    ) {
        $this->artsService = $artsService;
        $this->tagsService = $tagsService;
        $this->getPictureIdForPostingTask = $getPictureIdForPostingTask;
        $this->createSocialMediaPostingItemTask = $createSocialMediaPostingItemTask;
    }

    /**
     * @return void
     * @throws \App\Containers\Picture\Exceptions\NotFoundPicture
     * @throws \App\Containers\SocialMediaPosting\Exceptions\NotFoundPictureIdForPostingException
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function broadcast(): void
    {
        $artIdForPosting = $this->getPictureIdForPostingTask->run();
        $art = $this->artsService->getById($artIdForPosting);
        $tags = $this->tagsService->getNamesWithoutHiddenVkByArtId($artIdForPosting);
        $artFsPath = $art['images']['primary']['fs_path'];
        $postingStrategy = new VkWallPostingStrategy($tags, $artFsPath);
        $postingStrategy->post();
        $this->createSocialMediaPostingItemTask->run($artIdForPosting);
    }

}

