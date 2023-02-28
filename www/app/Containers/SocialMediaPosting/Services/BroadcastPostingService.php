<?php

namespace App\Containers\SocialMediaPosting\Services;

use App\Containers\Picture\Exceptions\NotFoundPicture;
use App\Containers\Picture\Services\ArtsService;
use App\Containers\Picture\Tasks\Picture\GetPictureIdForPostingTask;
use App\Containers\SocialMediaPosting\Exceptions\NotFoundPictureIdForPostingException;
use App\Containers\SocialMediaPosting\Tasks\CreateSocialMediaPostingItemTask;
use App\Containers\Tag\Services\TagsService;
use App\Containers\Vk\Services\VkWallPostingStrategy;
use Illuminate\Contracts\Container\BindingResolutionException;
use Prettus\Repository\Exceptions\RepositoryException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

/**
 * @see \App\Containers\SocialMediaPosting\Tests\Feature\Services\BroadcastPostingServiceTest
 */
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
     * @throws BindingResolutionException
     * @throws NotFoundPicture
     * @throws NotFoundPictureIdForPostingException
     * @throws RepositoryException
     * @throws UnknownProperties
     */
    public function broadcast(): void
    {
        $pictureIdForPosting = $this->getPictureIdForPostingTask->run();
        $picture = $this->artsService->getByIdWithFiles($pictureIdForPosting);
        $tags = $this->tagsService->getNamesWithoutHiddenVkByArtId($pictureIdForPosting);
        $pictureFsPath = $picture->images->primary->fs_path;
        $postingStrategy = app()->make(VkWallPostingStrategy::class, ['tags' => $tags, 'artPath' => $pictureFsPath]);
        $postingStrategy->post();
        $this->createSocialMediaPostingItemTask->run($pictureIdForPosting);
    }

}

