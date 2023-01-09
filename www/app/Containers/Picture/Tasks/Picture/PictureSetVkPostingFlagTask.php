<?php

namespace App\Containers\Picture\Tasks\Picture;

use App\Containers\Picture\Data\Repositories\PictureRepository;
use App\Containers\Picture\Models\PictureModel;
use App\Ship\Enums\FlagsEnum;
use App\Ship\Parents\Tasks\Task;

class PictureSetVkPostingFlagTask extends Task
{

    protected PictureRepository $repository;

    public function __construct(PictureRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $id
     * @return PictureModel
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function run(int $id): PictureModel
    {
        /** @var PictureModel $model */
        $model = $this->repository->getModel()
            ->findOrFail($id);
        $model->flag(FlagsEnum::PICTURE_IN_VK_POSTING);
        return $model;
    }
}


