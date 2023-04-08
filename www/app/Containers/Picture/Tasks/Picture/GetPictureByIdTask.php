<?php

namespace App\Containers\Picture\Tasks\Picture;

use App\Containers\Picture\Data\Repositories\PictureRepository;
use App\Containers\Picture\Exceptions\NotFoundPicture;
use App\Containers\Picture\Models\PictureModel;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GetPictureByIdTask extends Task
{

    protected PictureRepository $repository;

    public function __construct(PictureRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws NotFoundPicture
     */
    public function run(int $id): ?PictureModel
    {
        try {
            return $this->repository->find($id);
        } catch (ModelNotFoundException $exception) {
            throw new NotFoundPicture();
        }
    }
}


