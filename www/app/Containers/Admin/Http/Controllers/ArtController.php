<?php

namespace App\Containers\Admin\Http\Controllers;

use App\Containers\Admin\Http\Requests\Art\PostInVkAlbumRequest;
use App\Containers\Admin\Http\Requests\Art\RemoveFromVkAlbumRequest;
use App\Containers\Admin\Http\Requests\VkPosting\ArtSetVkPostingRequest;
use App\Containers\Picture\Services\ArtsService;
use App\Containers\Picture\Tasks\Picture\UpdatePictureVkPostingStatusTask;
use App\Containers\Vk\Enums\VkPostingStatusEnum;
use App\Containers\Vk\Services\AlbumService;
use App\Containers\Vk\Services\Posting\VkAlbumService;
use App\Ship\Parents\Controllers\HttpController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Throwable;

class ArtController extends HttpController
{

    private VkAlbumService $vkAlbumService;
    private AlbumService $albumService;

    public function __construct(VkAlbumService $vkAlbumService, AlbumService $albumService, ArtsService $artsService)
    {
        $this->vkAlbumService = $vkAlbumService;
        $this->albumService = $albumService;
    }

    /**
     * @param ArtSetVkPostingRequest $request
     * @param UpdatePictureVkPostingStatusTask $task
     * @return JsonResponse
     *
     * @see \App\Containers\Admin\Tests\Feature\Http\Controllers\SetVkPostingOnTest
     */
    public function setVkPostingOn(
        ArtSetVkPostingRequest $request,
        UpdatePictureVkPostingStatusTask $task
    ): JsonResponse {
        try {
            $task->run($request->id, VkPostingStatusEnum::TRUE);
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            abort(500);
        }
        return response()->json();
    }

    /**
     * @param ArtSetVkPostingRequest $request
     * @param UpdatePictureVkPostingStatusTask $task
     * @return JsonResponse
     *
     * @see \App\Containers\Admin\Tests\Feature\Http\Controllers\SetVkPostingOffTest
     */
    public function setVkPostingOff(
        ArtSetVkPostingRequest $request,
        UpdatePictureVkPostingStatusTask $task
    ): JsonResponse {
        try {
            $task->run($request->id, VkPostingStatusEnum::FALSE);
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            abort(500);
        }
        return response()->json();
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
        } catch (Throwable $e) {
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
        } catch (Throwable $e) {
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
        } catch (Throwable $e) {
            return response(['success' => false]);
        }
        return ['success' => true];
    }
}
