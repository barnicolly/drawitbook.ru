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

    public function __construct(protected PictureRepository $repository)
    {
    }

    public function run(int $tagId, int $perPage): LengthAwarePaginator
    {
        return $this->repository
            ->whereHas('tags', static function (BuilderContract $q) use ($tagId) : void {
                $q->where(SprTagsColumnsEnum::tId, $tagId);
            })
            ->paginate($perPage, [PictureColumnsEnum::ID]);
    }
}


