<?php

namespace App\Containers\Admin\Http\Controllers;

use App\Containers\Admin\Actions\AttachPictureOnAlbumAction;
use App\Containers\Admin\Actions\DetachPictureFromAlbumAction;
use App\Containers\Admin\Actions\GetSettingsModalAction;
use App\Containers\Admin\Http\Requests\Art\AttachPictureOnAlbumRequest;
use App\Containers\Admin\Http\Requests\Art\DetachPictureFromAlbumRequest;
use App\Containers\Admin\Http\Requests\Settings\GetSettingsModalRequest;
use App\Containers\Admin\Http\Requests\VkPosting\ArtSetVkPostingRequest;
use App\Containers\Picture\Tasks\Picture\PictureSetVkPostingFlagTask;
use App\Containers\Picture\Tasks\Picture\PictureUnsetVkPostingFlagTask;
use App\Ship\Parents\Controllers\HttpController;
use App\Ship\Parents\Resources\JsonResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Throwable;

class ArtController extends HttpController
{
    /**
     * @see \App\Containers\Admin\Tests\Feature\Http\Controllers\SetVkPostingOnTest
     */
    public function setVkPostingOn(
        ArtSetVkPostingRequest $request,
        PictureSetVkPostingFlagTask $task,
    ): JsonResponse {
        try {
            $task->run($request->id);
        } catch (Throwable $e) {
            Log::error($e);
            abort(500);
        }
        return response()->json();
    }

    /**
     * @see \App\Containers\Admin\Tests\Feature\Http\Controllers\SetVkPostingOffTest
     */
    public function setVkPostingOff(
        ArtSetVkPostingRequest $request,
        PictureUnsetVkPostingFlagTask $task,
    ): JsonResponse {
        try {
            $task->run($request->id);
        } catch (Throwable $e) {
            Log::error($e);
            abort(500);
        }
        return response()->json();
    }

    /**
     * @see  \App\Containers\Admin\Tests\Feature\Http\Controllers\GetSettingsModalTest
     */
    public function getSettingsModal(GetSettingsModalRequest $request, GetSettingsModalAction $action): JsonResponse
    {
        try {
            $resultDto = $action->run($request->id);
            return JsonResource::make($resultDto)
                ->response();
        } catch (Throwable $e) {
            Log::error($e);
            abort(500);
        }
    }

    /**
     * @see \App\Containers\Admin\Tests\Feature\Http\Controllers\AttachPictureOnAlbumTest
     */
    public function attachPictureOnAlbum(
        AttachPictureOnAlbumRequest $request,
        AttachPictureOnAlbumAction $action,
    ): JsonResponse {
        try {
            $action->run($request->id, $request->album_id);
        } catch (Throwable $e) {
            Log::error($e);
            abort(500);
        }
        return response()->json();
    }

    /**
     * @see \App\Containers\Admin\Tests\Feature\Http\Controllers\AttachPictureOnAlbumTest
     */
    public function detachPictureFromAlbum(
        DetachPictureFromAlbumRequest $request,
        DetachPictureFromAlbumAction $action,
    ): JsonResponse {
        try {
            $action->run($request->id, $request->album_id);
        } catch (Throwable $e) {
            Log::error($e);
            abort(500);
        }
        return response()->json();
    }
}
