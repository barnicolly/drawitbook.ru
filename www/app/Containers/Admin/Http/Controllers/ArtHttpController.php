<?php

namespace App\Containers\Admin\Http\Controllers;

use App\Containers\Admin\Http\Requests\Art\ArtSetVkPostingOffRequest;
use App\Containers\Admin\Http\Requests\Art\ArtSetVkPostingOnRequest;
use App\Containers\Admin\Http\Requests\Art\PostInVkAlbumRequest;
use App\Containers\Admin\Http\Requests\Art\RemoveFromVkAlbumRequest;
use App\Containers\Picture\Services\ArtsService;
use App\Containers\Picture\Tasks\Picture\UpdatePictureVkPostingStatusTask;
use App\Containers\Vk\Enums\VkPostingStatusEnum;
use App\Containers\Vk\Services\AlbumService;
use App\Containers\Vk\Services\Posting\VkAlbumService;
use App\Ship\Parents\Controllers\HttpController;

class ArtHttpController extends HttpController
{

    private VkAlbumService $vkAlbumService;
    private AlbumService $albumService;
    private ArtsService $artsService;

    public function __construct(VkAlbumService $vkAlbumService, AlbumService $albumService, ArtsService $artsService)
    {
        $this->vkAlbumService = $vkAlbumService;
        $this->albumService = $albumService;
        $this->artsService = $artsService;
    }

    public function setVkPostingOnRequest(ArtSetVkPostingOnRequest $request)
    {
        try {
            $data = $request->validated();
            if (!$this->artsService->isArtExist($data['id'])) {
                return ['success' => false];
            }
            app(UpdatePictureVkPostingStatusTask::class)->run($data['id'], VkPostingStatusEnum::TRUE);
        } catch (\Exception $e) {
            return ['success' => false];
        }
        return response(['success' => true]);
    }

    public function setVkPostingOffRequest(ArtSetVkPostingOffRequest $request)
    {
        try {
            $data = $request->validated();
            if (!$this->artsService->isArtExist($data['id'])) {
                return ['success' => false];
            }
            app(UpdatePictureVkPostingStatusTask::class)->run($data['id'], VkPostingStatusEnum::FALSE);
        } catch (\Exception $e) {
            return ['success' => false];
        }
        return response(['success' => true]);
    }

    public function getSettingsModal($artId)
    {
        try {
            $vkAlbums = $this->albumService->getVkAlbums();
            $vkAlbumIds = array_column($vkAlbums, 'id');
            $viewData['vkAlbums'] = $vkAlbums;
            $vkAlbumPictures = $this->albumService->getAlbumVkPictures($artId, $vkAlbumIds);
            $viewData['issetInVkAlbums'] = $this->albumService->extractVkAlbumIds($vkAlbumPictures);
            $modal = view('admin::art.modal', $viewData)->render();
        } catch (\Throwable $e) {
            return response(['success' => false]);
        }
        return ['success' => true, 'data' => $modal];
    }

    public function postInVkAlbum($artId, PostInVkAlbumRequest $request)
    {
        try {
            $data = $request->validated();
            $albumId = $data['album_id'];
            $this->vkAlbumService->attachArtOnAlbum($artId, $albumId);
        } catch (\Throwable $e) {
            return response(['success' => false]);
        }
        return ['success' => true];
    }

    public function removeFromVkAlbum($artId, RemoveFromVkAlbumRequest $request)
    {
        try {
            $data = $request->validated();
            $albumId = $data['album_id'];
            $this->vkAlbumService->detachArtFromAlbum($artId, $albumId);
        } catch (\Throwable $e) {
            return response(['success' => false]);
        }
        return ['success' => true];
    }
}
