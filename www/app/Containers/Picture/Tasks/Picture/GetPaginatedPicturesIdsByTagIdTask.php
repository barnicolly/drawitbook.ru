<?php

namespace App\Containers\Picture\Tasks\Picture;

use App\Containers\Picture\Data\Repositories\PictureRepository;
use App\Containers\Picture\Enums\PictureColumnsEnum;
use App\Containers\Tag\Enums\SprTagsColumnsEnum;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Contracts\Database\Query\Builder as BuilderContract;
use Illuminate\Pagination\LengthAwarePaginator;

class GetPaginatedPicturesIdsByTagIdTask extends Task
{

    protected PictureRepository $repository;

    public function __construct(PictureRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $tagId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function run(int $tagId, int $perPage): LengthAwarePaginator
    {
        return $this->repository
            ->whereHas('tags', function (BuilderContract $q) use ($tagId) {
                $q->where(SprTagsColumnsEnum::tId, $tagId);
            })
            ->paginate($perPage, [PictureColumnsEnum::ID]);
    }
}


