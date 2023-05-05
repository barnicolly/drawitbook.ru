<?php

namespace App\Containers\Picture\Tasks\Picture;

use Prettus\Validator\Exceptions\ValidatorException;
use App\Containers\Picture\Models\PictureModel;
use App\Ship\Enums\FlagsEnum;
use App\Ship\Parents\Tasks\Task;

class PictureSetVkPostingFlagTask extends Task
{
    /**
     * @throws ValidatorException
     */
    public function run(int $id): PictureModel
    {
        /** @var PictureModel $model */
        $model = PictureModel::findOrFail($id);
        $model->flag(FlagsEnum::PICTURE_IN_VK_POSTING);
        return $model;
    }
}
