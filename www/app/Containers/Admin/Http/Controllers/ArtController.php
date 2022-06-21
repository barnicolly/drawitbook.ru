<?php

namespace App\Containers\Admin\Http\Controllers;

use App\Containers\Admin\Actions\GetSettingsModalAction;
use App\Containers\Admin\Http\Requests\Art\PostInVkAlbumRequest;
use App\Containers\Admin\Http\Requests\Art\RemoveFromVkAlbumRequest;
use App\Containers\Admin\Http\Requests\Settings\GetSettingsModalRequest;
use App\Containers\Admin\Http\Requests\VkPosting\ArtSetVkPostingRequest;
use App\Containers\Admin\Http\Transformers\GetSettingsModalTransformer;
use App\Containers\Picture\Tasks\Picture\UpdatePictureVkPostingStatusTask;
use App\Containers\Vk\Enums\VkPostingStatusEnum;
use App\Containers\Vk\Services\Posting\VkAlbumService;
use App\Ship\Parents\Controllers\HttpController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Throwable;

class ArtController extends HttpController
{

    private VkAlbumService $vkAlbumService;

    public function __construct(VkAlbumService $vkAlbumService)
    {
        $this->vkAlbumService = $vkAlbumService;
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

    /**
     * @param GetSettingsModalRequest $request
     * @param GetSettingsModalAction $action
     * @return JsonResponse
     *
     * @see  \App\Containers\Admin\Tests\Feature\Http\Controllers\GetSettingsModalTest
     */
    public function getSettingsModal(GetSettingsModalRequest $request, GetSettingsModalAction $action): JsonResponse
    {
        try {
            $resultDto = $action->run($request->id);
            $result = fractal()->item($resultDto, new GetSettingsModalTransformer());
            return response()->json($result);
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            abort(500);
        }
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
