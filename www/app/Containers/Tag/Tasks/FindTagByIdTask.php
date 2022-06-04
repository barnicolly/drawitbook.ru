<?php

namespace App\Containers\Tag\Tasks;

use App\Containers\Tag\Data\Repositories\TagRepository;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FindTagByIdTask extends Task
{

    protected TagRepository $repository;

    public function __construct(TagRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(int $id): ?array
    {
        try {
            return $this->repository->find($id)->toArray();
        } catch (ModelNotFoundException $exception) {
            return null;
        }
    }
}


