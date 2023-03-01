<?php

namespace App\Containers\SocialMediaPosting\Services;

use App\Containers\Picture\Actions\Art\GetArtByIdWithFilesAction;
use App\Containers\Picture\Exceptions\NotFoundPicture;
use App\Containers\Picture\Tasks\Picture\GetPictureIdForPostingTask;
use App\Containers\Picture\Tasks\PictureTag\GetPictureTagsNamesWithoutHiddenVkByPictureIdTask;
use App\Containers\SocialMediaPosting\Exceptions\NotFoundPictureIdForPostingException;
use App\Containers\SocialMediaPosting\Tasks\CreateSocialMediaPostingItemTask;
use App\Containers\Vk\Services\VkWallPostingStrategy;
use Illuminate\Contracts\Container\BindingResolutionException;
use Prettus\Repository\Exceptions\RepositoryException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

/**
 * @see \App\Containers\SocialMediaPosting\Tests\Feature\Services\BroadcastPostingServiceTest
 */
class BroadcastPostingService
{

    private GetPictureIdForPostingTask $getPictureIdForPostingTask;
    private CreateSocialMediaPostingItemTask $createSocialMediaPostingItemTask;
    private GetPictureTagsNamesWithoutHiddenVkByPictureIdTask $getPictureTagsNamesWithoutHiddenVkByPictureIdTask;
    private GetArtByIdWithFilesAction $getArtByIdWithFilesAction;

    public function __construct(
        GetPictureIdForPostingTask $getPictureIdForPostingTask,
        CreateSocialMediaPostingItemTask $createSocialMediaPostingItemTask,
        GetPictureTagsNamesWithoutHiddenVkByPictureIdTask $getPictureTagsNamesWithoutHiddenVkByPictureIdTask,
        GetArtByIdWithFilesAction $getArtByIdWithFilesAction,
    ) {
        $this->getPictureIdForPostingTask = $getPictureIdForPostingTask;
        $this->createSocialMediaPostingItemTask = $createSocialMediaPostingItemTask;
        $this->getPictureTagsNamesWithoutHiddenVkByPictureIdTask = $getPictureTagsNamesWithoutHiddenVkByPictureIdTask;
        $this->getArtByIdWithFilesAction = $getArtByIdWithFilesAction;
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
        $picture = $this->getArtByIdWithFilesAction->run($pictureIdForPosting);
        $tags = $this->getPictureTagsNamesWithoutHiddenVkByPictureIdTask->run($pictureIdForPosting);
        $pictureFsPath = $picture->images->primary->fs_path;
        $postingStrategy = app()->make(VkWallPostingStrategy::class, ['tags' => $tags, 'artPath' => $pictureFsPath]);
        $postingStrategy->post();
        $this->createSocialMediaPostingItemTask->run($pictureIdForPosting);
    }

}

