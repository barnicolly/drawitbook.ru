<?php

namespace App\Containers\Picture\Tasks\Picture;

use App\Containers\Picture\Data\Repositories\PictureRepository;
use App\Containers\Picture\Enums\PictureColumnsEnum;
use App\Containers\Picture\Models\PictureModel;
use App\Ship\Parents\Tasks\Task;

class UpdatePictureVkPostingStatusTask extends Task
{

    protected PictureRepository $repository;

    public function __construct(PictureRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(int $id, int $status): PictureModel
    {
        $attributes = [
            PictureColumnsEnum::IN_VK_POSTING => $status,
        ];
        return $this->repository->update($attributes, $id);
    }
}


