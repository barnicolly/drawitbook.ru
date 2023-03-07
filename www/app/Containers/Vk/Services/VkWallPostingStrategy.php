<?php

namespace App\Containers\Vk\Services;

use App\Containers\SocialMediaPosting\Contracts\SocialMediaPostingContract;
use App\Containers\Vk\Services\Api\PhotoService;
use App\Containers\Vk\Services\Api\VkApi;
use App\Containers\Vk\Services\Api\WallService;
use App\Containers\Vk\Tasks\FormHashTagsTask;

class VkWallPostingStrategy implements SocialMediaPostingContract
{
    private array $tags;
    private string $artPath;

    private VkApi $apiInstance;

    private PhotoService $photoService;
    private WallService $wallService;

    private string $url = 'https://drawitbook.com/ru';

    private FormHashTagsTask $formHashTagsTask;

    public function __construct(array $tags, string $artPath)
    {
        $this->tags = $tags;
        $this->artPath = $artPath;
        $apiInstance = (new VkApi());
        $this->apiInstance = $apiInstance;
        $this->photoService = (new PhotoService($apiInstance));
        $this->wallService = (new WallService($apiInstance));
        $this->formHashTagsTask = app(FormHashTagsTask::class);
    }

    public function post(): void
    {
        $this->create();
    }

    private function create(): void
    {
        $hashTags = $this->formHashTagsTask->run($this->tags);
        $uploadedPhoto = $this->photoService->saveWallPhoto($this->artPath);
        $postId = $this->createPost($uploadedPhoto['owner_id'], $uploadedPhoto['id'], $hashTags);
        if (empty($postId)) {
            throw new \Exception();
        }
        $lastWallPhotoId = $this->photoService->getLastOnWall();
        if ($lastWallPhotoId) {
            $photoData = [
                'caption' => $hashTags . "\n\n" . 'Ещё больше рисунков на ' . $this->url . "\n\n" . 'Рисуйте)',
            ];
            $this->photoService->edit($lastWallPhotoId, $photoData);
            $this->editPost($postId, $hashTags, $lastWallPhotoId);
        }
    }

    private function createPost(int $ownerId, int $photoId, string $hashTags): ?int
    {
        $photoAttachment = $this->formPhotoOwnerAttachmentString($ownerId, $photoId);
        $attachments = implode(',', [$photoAttachment, $this->url]);
        return $this->wallService->create(['message' => $hashTags, 'attachments' => $attachments]);
    }

    private function editPost(int $postId, string $hashTags, int $lastWallPhotoId): void
    {
        $photoAttachment = $this->formPhotoGroupAttachmentString($lastWallPhotoId);
        $attachments = implode(',', [$photoAttachment, $this->url]);
        $this->wallService->edit($postId, ['message' => $hashTags, 'attachments' => $attachments]);
    }

    private function formPhotoOwnerAttachmentString(int $ownerId, int $photoId): string
    {
        return 'photo' . $ownerId . '_' . $photoId;
    }

    private function formPhotoGroupAttachmentString(int $photoId): string
    {
        return 'photo-' . $this->apiInstance->groupId . '_' . $photoId;
    }
}

