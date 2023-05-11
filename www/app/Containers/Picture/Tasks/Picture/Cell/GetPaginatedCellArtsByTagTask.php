<?php

namespace App\Containers\Picture\Tasks\Picture\Cell;

use App\Containers\Picture\Actions\Art\GetArtsByIdsAction;
use App\Containers\Picture\Enums\PictureColumnsEnum;
use App\Containers\Picture\Exceptions\NotFoundRelativeArts;
use App\Containers\Picture\Tasks\Picture\GetPaginatedPicturesIdsByTagIdTask;
use App\Ship\Factories\PaginatorFactory;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Pagination\LengthAwarePaginator;

class GetPaginatedCellArtsByTagTask extends Task
{
    public function __construct(
        private readonly GetArtsByIdsAction $getArtsByIdsAction,
        private readonly GetPaginatedPicturesIdsByTagIdTask $getPaginatedPicturesIdsByTagIdTask,
    ) {
    }

    public function run(int $tagId): LengthAwarePaginator
    {
        $paginator = $this->getPaginatedPicturesIdsByTagIdTask->run($tagId, PaginatorFactory::DEFAULT_PER_PAGE);
        if (!$paginator->isNotEmpty()) {
            throw new NotFoundRelativeArts();
        }
        $relativeArtIds = $paginator->getCollection()->pluck(PictureColumnsEnum::ID)->toArray();
        $relativeArts = $this->getArtsByIdsAction->run($relativeArtIds);
        return PaginatorFactory::createFromAnother($paginator, collect($relativeArts));
    }
}
