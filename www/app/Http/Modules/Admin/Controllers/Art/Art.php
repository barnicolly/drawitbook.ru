<?php

namespace App\Http\Modules\Admin\Controllers\Art;

use App\Http\Controllers\Controller;
use App\Http\Modules\Admin\Requests\Art\ArtSetVkPostingOffRequest;
use App\Http\Modules\Admin\Requests\Art\ArtSetVkPostingOnRequest;
use Validator;
use App\Http\Modules\Database\Models\Common\Picture\PictureModel;

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
}
