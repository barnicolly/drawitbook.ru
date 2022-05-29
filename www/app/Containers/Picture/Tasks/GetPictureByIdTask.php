<?php

namespace App\Containers\Picture\Tasks;

use App\Containers\Picture\Data\Criteria\WherePictureNotDeletedCriteria;
use App\Containers\Picture\Data\Repositories\PictureRepository;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GetPictureByIdTask extends Task
{

    protected PictureRepository $repository;

    public function __construct(PictureRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(int $id): ?array
    {
        try {
            $this->repository->pushCriteria(new WherePictureNotDeletedCriteria());
            return $this->repository->find($id)->toArray();
        } catch (ModelNotFoundException $exception) {
            return null;
        }
    }
}


