<?php

declare(strict_types=1);

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
final class BroadcastPostingService
{
    public function __construct(
        private readonly GetPictureIdForPostingTask $getPictureIdForPostingTask,
        private readonly CreateSocialMediaPostingItemTask $createSocialMediaPostingItemTask,
        private readonly GetPictureTagsNamesWithoutHiddenVkByPictureIdTask $getPictureTagsNamesWithoutHiddenVkByPictureIdTask,
        private readonly GetArtByIdWithFilesAction $getArtByIdWithFilesAction,
    ) {
    }

    /**
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
        $pictureUrlPath = $picture->images->primary->url;
        $postingStrategy = app()->make(VkWallPostingStrategy::class, ['tags' => $tags, 'artPath' => $pictureUrlPath]);
        $postingStrategy->post();
        $this->createSocialMediaPostingItemTask->run($pictureIdForPosting);
    }
}
