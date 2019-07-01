<?php

namespace App\Http\Modules\Admin\Controllers\Moderate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Http\Modules\Database\Models\Moderate\PagesModel;
use App\Http\Modules\Admin\Controllers\TagRules;
use App\Http\Modules\Database\Models\Common\Picture\PictureModel;
use Illuminate\Support\Facades\DB;
use App\Entities\Spr\SprTagsModel;

class SaveImage extends Controller
{

    public function saveImage(Request $request)
    {
        $data = [
            'description' => $request->input('description'),
            'tags' => $request->input('tags'),
        ];
        $saveResult = $this->_saveImage($request->input('id'), $data, $request->input('donor_id'));
        return response($saveResult);
    }

    private function _getUnigueFileName(string $fileName)
    {
        $path = base_path('public/moderate/in_moderate/' . $fileName);
        return $this->_copyFileFromModerateFolderToArt($path, base_path('public/arts/'));
    }

    private function _removeFile(string $fileName)
    {
        unlink(base_path('public/arts/') . $fileName);
    }

    private function _saveImage(int $id, array $data, int $donorId)
    {
        $defaultTransaction = DB::connection('mysql');
        $moderateTransaction = DB::connection('moderate');
        $picture = PictureModel::findOrNew($id);
        try {
            $tagsPayload = array_unique(trimData($data['tags']));
            if (!$tagsPayload) {
                return ['success' => false, 'message' => 'Нет тегов'];
            }
            $defaultTransaction->beginTransaction();
            $moderateTransaction->beginTransaction();
            if (!$picture->path) {
                $image = PagesModel::find($donorId);
                $image->status = 2;
                $image->save();
                $newFileName = $this->_getUnigueFileName($image->file_name);
                $picture->path = $newFileName;
            }
            $picture->description = $data['description'];
            $picture->save();
            $savedTags = $picture->tags;
            if (!$savedTags->count()) {
                $tagRules = new TagRules();
                $tagsToSave = $tagRules->appendByRules($tagsPayload);


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
            $defaultTransaction->commit();
            $moderateTransaction->commit();
        } catch (\Exception $e) {
            if (isset($newFileName)) {
                $this->_removeFile($newFileName);
            }
            $defaultTransaction->rollBack();
            $moderateTransaction->rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
        return ['success' => true, 'picture_id' => $picture->id];
    }

    private function _copyFileFromModerateFolderToArt(string $path, string $destinyFolder)
    {
        $info = pathinfo($path);
        $ext = $info['extension'];
        list($uniqueFileName, $destinyDir) = $this->_createUniqueFileName($destinyFolder, $ext);
        if (!mkdir($destinyDir, 0777, true)) {
            throw new \Exception('Нет прав на создание каталога в ' . $destinyDir);
        };
        $destinyPath = $destinyFolder . $uniqueFileName;
        if (!copy($path, $destinyPath)) {
            throw new \Exception('Нет прав на копирование файла в ' . $destinyPath);
        }
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
