<?php

namespace App\Containers\Picture\Tasks\Picture;

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

    /**
     * @param int $id
     * @return array|null
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function run(int $id): ?array
    {
        try {
            return $this->repository->find($id)->toArray();
        } catch (ModelNotFoundException $exception) {
            return null;
        }
    }
}


