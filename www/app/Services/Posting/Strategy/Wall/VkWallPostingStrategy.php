<?php

namespace App\Services\Posting\Strategy\Wall;

use App\Entities\Vk\HistoryPostingModel;
use App\Services\Api\Vk\Core\PhotoService;
use App\Services\Api\Vk\Core\VkApi;
use App\Services\Api\Vk\Core\WallService;

class VkWallPostingStrategy
{
    private $tags;
    private $artId;
    private $artPath;

    private $apiInstance;

    private $photoService;
    private $wallService;

    private $url = 'https://drawitbook.ru';

    public function __construct(int $artId, array $tags, string $artPath)
    {
        $this->artId = $artId;
        $this->tags = $tags;
        $this->artPath = $artPath;
        $apiInstance = (new VkApi());
        $this->apiInstance = $apiInstance;
        $this->photoService = (new PhotoService($apiInstance));
        $this->wallService = (new WallService($apiInstance));
    }

    public function post()
    {
        $this->create();
        $this->addHistoryVkPosting();
    }

    private function addHistoryVkPosting()
    {
        $historyVkPostingRecord = new HistoryPostingModel();
        $historyVkPostingRecord->picture_id = $this->artId;
        $historyVkPostingRecord->save();
    }

    private function create()
    {
        $hashTags = $this->formHashTags($this->tags);
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

    private function formHashTags(array $tags): string
    {
        foreach ($tags as $key => $tag) {
            $tags[$key] = preg_replace('/\s+/', '', $tag);
            $tags[$key] = str_ireplace('-', '', $tags[$key]);
        }
        $hashTags = '#рисунки #рисункипоклеточкам';
        if ($tags) {
            $hashTags .= ' #' . implode(' #', $tags);
        }
        $hashTags .= ' #drawitbook';
        return $hashTags;
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

