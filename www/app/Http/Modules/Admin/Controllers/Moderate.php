<?php

namespace App\Http\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\Template;
use Illuminate\Http\Request;
use Validator;
use App\Http\Modules\Database\Models\Moderate\PagesModel;
use App\Http\Modules\Database\Models\Common\Picture\PictureModel;
use App\Http\Modules\Database\Models\Common\Spr\SprTagsModel;

class Moderate extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {
        $countNonModeratedRecords = PagesModel::where('status', '=', 1)
            ->where('is_del', '=', 0)
            ->count();

        $template = new Template();
        $images = PagesModel::take(10)
            ->where('is_del', '=', 0)
            ->where('status', '=', 1)
            ->get();

        $viewData['countNonModeratedRecords'] = $countNonModeratedRecords;
        $viewData['images'] = $images;
        $viewData['popular'] = $this->_popularTags();
        return $template->loadView('Admin::moderate.index', $viewData);
    }

    public function deleteImage(Request $request)
    {
        $image = PagesModel::find($request->input('id'));
        $image->is_del = 1;
        $image->save();
        return response(['success' => true]);
    }

    public function saveImage(Request $request)
    {
        $picture = PictureModel::findOrNew($request->input('id'));
        if (!$picture->path) {
            $image = PagesModel::find($request->input('donor_id'));
            $path = base_path('public/moderate/in_moderate/' . $image->file_name);
            $uniqueFileName = $this->_copyFileFromModerateFolderToArt($path, base_path('public/art/'));
            $image->status = 2;
            $image->save();
            $picture->path = $uniqueFileName;
        }
        $picture->description = $request->input('description');
        $picture->save();
        $tagsPayload = trimData($request->input('tags'));
        if (!$tagsPayload) {
            return response(['success' => false, 'message' => 'Нет тегов']);
        }

        $savedTags = $picture->tags;
        if (!$savedTags->count()) {
            $tagsToSave = $tagsPayload;
        } else {
            $savedTagNames = $savedTags->pluck('name')->toArray();
            $collection = collect($savedTagNames);
            $diff = $collection->diff($tagsPayload);
            $tagNamesForRemove = $diff->all();
            if ($tagNamesForRemove) {
                $tagIds = SprTagsModel::whereIn('name', $tagNamesForRemove)->pluck('id')->toArray();
                if ($tagIds) {
                    $picture->tags()->detach($tagIds);
                }
            }
            $collection = collect($tagsPayload);
            $diff = $collection->diff($savedTagNames);
            $tagsToSave = $diff->all();
        }
        $tags = [];
        foreach ($tagsToSave as $tagName) {
            $tag = SprTagsModel::firstOrCreate(['name' => $tagName], ['name' => $tagName]);
            $tags[] = $tag;
        }
        $picture->tags()->saveMany($tags);

        return response(['success' => true, 'picture_id' => $picture->id]);
    }

    private function _popularTags()
    {
        return [
           'для девочек',
           'майнкрафт',
           'minecraft',
           'в тетради',
           'легкие',
           'сложные',
           'фрукты',
           'цветы',
           'большие',
           'красивые',
           'животные',
           'для детей',
           'еда',
           'для дошкольников',
           'котики',
           'аниме',
           'черно-белые',
           'цветные',
           'для мальчиков',
           'оружие',
           'на 8 марта',
           'машины',
           'новый год',
           'графити',
           'гравити фолз',
           'карандашом',
           'девушки',
           'прикольные',
           'интересные',
           'милые и няшные',
           'дом',
        ];
    }

    private function _copyFileFromModerateFolderToArt(string $path, string $destinyFolder)
    {
        $info = pathinfo($path);
        $ext = $info['extension'];
        list($uniqueFileName, $destinyDir) = $this->_createUniqueFileName($destinyFolder, $ext);
        mkdir($destinyDir, 0777, true);
        $destinyPath = $destinyFolder . $uniqueFileName;
        copy($path, $destinyPath);
        return $uniqueFileName;
    }

    private function _createUniqueFileName($tmpFolder, $ext)
    {
        $subFolders = 2;
        $countSymbols = 2;
        do {
            $fileNameHash = hash('md5', microtime(true));
            $folders = '';
            for ($i = 0; $i < $subFolders; $i++) {
                $firstTwoLetters = mb_substr($fileNameHash, $i * $countSymbols, $countSymbols);
                $folders .= $firstTwoLetters . '/';
            }
            $realPathDest = $tmpFolder . $folders . $fileNameHash . '.' . $ext;
        } while (file_exists($realPathDest));
        return [$folders . $fileNameHash . '.' . $ext, $tmpFolder . $folders];
    }

}
