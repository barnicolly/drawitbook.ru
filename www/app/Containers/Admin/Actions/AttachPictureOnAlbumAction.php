<?php

namespace App\Containers\Admin\Actions;

use App\Containers\Picture\Services\ArtsService;
use App\Containers\Tag\Services\TagsService;
use App\Containers\Vk\Services\AlbumService;
use App\Containers\Vk\Services\Api\PhotoService;
use App\Containers\Vk\Services\Api\VkApi;
use App\Containers\Vk\Services\Posting\PostingService;
use App\Ship\Parents\Actions\Action;

class AttachPictureOnAlbumAction extends Action
{
    private PhotoService $apiPhotoService;
    private PostingService $apiPostingService;
    private ArtsService $artsService;
    private TagsService $tagsService;
    private AlbumService $albumService;

    /**
     * @param PostingService $apiPostingService
     * @param ArtsService $artsService
     * @param TagsService $tagsService
     * @param AlbumService $albumService
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(PostingService $apiPostingService, ArtsService $artsService, TagsService $tagsService, AlbumService $albumService)
    {
//        todo-misha реализовать через контейнер;
        $apiInstance = app(VkApi::class);
        $this->apiPhotoService = app()->make(PhotoService::class, ['api' => $apiInstance]);
        $this->apiPostingService = $apiPostingService;
        $this->artsService = $artsService;
        $this->tagsService = $tagsService;
        $this->albumService = $albumService;
    }

    /**
     * @param int $artId
     * @param int $vkAlbumId
     * @return void
     *
     * @throws \Exception
     */
    public function run(int $artId, int $vkAlbumId): void
    {
        //        todo-misha вынести в таск проверки;
        $vkAlbum = $this->albumService->getById($vkAlbumId);
        //        todo-misha добавить exceptions;
        if (!$vkAlbum) {
            throw new \Exception('Не найден альбом');
        }
        //        todo-misha вынести в таск проверки;
        $art = $this->artsService->getById($artId);
        if (!$art) {
            throw new \Exception('Не найдено изображения');
        }
        $artFsPath = $art['images']['primary']['fs_path'];
        $tags = $this->tagsService->getNamesWithoutHiddenVkByArtId($artId);
        $photoId = $this->postPhotoInAlbum($vkAlbum['album_id'], $vkAlbum['share'], $artFsPath, $tags);
        $this->artsService->attachArtToVkAlbum($artId, $vkAlbum['id'], $photoId);
    }

    private function postPhotoInAlbum(int $albumId, ?string $albumShareLink, string $path, array $tags): ?int
    {
        $photoId = $this->apiPhotoService->saveOnAlbum($path, $albumId);
        if ($albumShareLink) {
            $url = $albumShareLink;
        } else {
            $url = 'https://drawitbook.com/ru';
        }
        $hashTags = $this->apiPostingService->formHashTags($tags);
        $this->apiPhotoService->timeout();
        $this->apiPhotoService->edit($photoId, ['caption' => $hashTags . "\n\n" . ' Больше рисунков ► ' . $url], true);
        return $photoId;
    }

}


