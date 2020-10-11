<?php

namespace App\Http\Modules\Admin\Controllers\Art;

use App\Entities\Vk\VkAlbumPictureModel;
use App\Http\Controllers\Controller;
use App\Http\Modules\Admin\Requests\Art\ArtSetVkPostingOffRequest;
use App\Http\Modules\Admin\Requests\Art\ArtSetVkPostingOnRequest;
use App\Http\Modules\Admin\Requests\Art\PostInVkAlbumRequest;
use App\Http\Modules\Admin\Requests\Art\RemoveFromVkAlbumRequest;
use App\UseCases\Picture\GetPicture;
use App\UseCases\Vk\AttachArtToVkAlbum;
use App\UseCases\Vk\DetachArtFromVkAlbum;
use App\UseCases\Vk\GetVkAlbums;
use Validator;
use App\Entities\Picture\PictureModel;

class Art extends Controller
{

    public function setVkPostingOnRequest(ArtSetVkPostingOnRequest $request)
    {
        try {
            $data = $request->validated();
            $art = PictureModel::find($data['id']);
            if ($art === null) {
                return ['success' => false];
            }
            $art->in_vk_posting = ON_VK_POSTING;
            $art->save();
        } catch (\Exception $e) {
            return ['success' => false];
        }
        return response(['success' => true]);
    }

    public function setVkPostingOffRequest(ArtSetVkPostingOffRequest $request)
    {
        try {
            $data = $request->validated();
            $art = PictureModel::find($data['id']);
            if ($art === null) {
                return ['success' => false];
            }
            $art->in_vk_posting = OFF_VK_POSTING;
            $art->save();
        } catch (\Exception $e) {
            return ['success' => false];
        }
        return response(['success' => true]);
    }

    public function getSettingsModal($artId)
    {
        try {
            $getPicture = new GetPicture($artId);
            $picture = $getPicture->get();
            $viewData['picture'] = $picture;
            $getVkAlbum = new GetVkAlbums();
            $vkAlbums = $getVkAlbum->get();

            $vkAlbumIds = $vkAlbums->pluck('id')->toArray();
            $viewData['vkAlbums'] = $vkAlbums;

            $vkAlbumPictures = VkAlbumPictureModel::whereIn('vk_album_id', $vkAlbumIds)
                ->where('picture_id', $picture->id)
                ->get()
                ->toArray();
            $issetInVkAlbums = [];
            //TODO-misha вынести в метод
            if ($vkAlbumPictures) {
                foreach ($vkAlbumPictures as $vkAlbumPicture) {
                    $vkAlbumId = $vkAlbumPicture['vk_album_id'];
                    if (!in_array($vkAlbumId, $issetInVkAlbums, true)) {
                        $issetInVkAlbums[] = $vkAlbumId;
                    }
                }
            }
            $viewData['issetInVkAlbums'] = $issetInVkAlbums;
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
            $attachArtToVkAlbum = new AttachArtToVkAlbum($albumId, $artId);
            $attachArtToVkAlbum->attach();
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
            $detachArt = new DetachArtFromVkAlbum($albumId, $artId);
            $detachArt->detach();
        } catch (\Throwable $e) {
            return response(['success' => false]);
        }
        return ['success' => true];
    }
}
