<?php

namespace App\Http\Modules\Admin\Controllers\Art;

use App\Containers\Picture\Services\ArtsService;
use App\Http\Controllers\Controller;
use App\Http\Modules\Admin\Requests\Art\ArtSetVkPostingOffRequest;
use App\Http\Modules\Admin\Requests\Art\ArtSetVkPostingOnRequest;
use App\Http\Modules\Admin\Requests\Art\PostInVkAlbumRequest;
use App\Http\Modules\Admin\Requests\Art\RemoveFromVkAlbumRequest;
use App\Services\Album\AlbumService;
use App\Services\Posting\VkAlbumService;

class Art extends Controller
{

    private $vkAlbumService;
    private $albumService;
    private $artsService;

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
            $this->artsService->updateVkPosting($data['id'], OFF_VK_POSTING);
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
            $this->artsService->updateVkPosting($data['id'], OFF_VK_POSTING);
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
            $modal = view('Admin::art.modal', $viewData)->render();
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
