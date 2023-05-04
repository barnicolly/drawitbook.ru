<?php

namespace App\Containers\Picture\Tasks\Picture;

use Prettus\Validator\Exceptions\ValidatorException;
use App\Containers\Picture\Data\Repositories\PictureRepository;
use App\Containers\Picture\Models\PictureModel;
use App\Ship\Enums\FlagsEnum;
use App\Ship\Parents\Tasks\Task;

class PictureUnsetVkPostingFlagTask extends Task
{
    public function __construct(protected PictureRepository $repository)
    {
    }

    /**
     * @throws ValidatorException
     */
    public function run(int $id): PictureModel
    {
        /** @var PictureModel $model */
        $model = $this->repository->getModel()
            ->findOrFail($id);
        $model->unflag(FlagsEnum::PICTURE_IN_VK_POSTING);
        return $model;
    }
}
