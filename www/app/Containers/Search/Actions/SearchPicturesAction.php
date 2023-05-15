<?php

namespace App\Containers\Search\Actions;

use App\Containers\Picture\Actions\Art\GetArtsByIdsAction;
use App\Containers\Picture\Models\PictureModel;
use App\Containers\Search\Data\Dto\SearchDto;
use App\Containers\Search\Tasks\SearchInElasticSearchTask;
use App\Ship\Factories\PaginatorFactory;
use App\Ship\Parents\Actions\Action;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchPicturesAction extends Action
{
    public function __construct(
        private readonly GetArtsByIdsAction $getArtsByIdsAction,
    ) {
    }

    public function run(SearchDto $searchDto): LengthAwarePaginator
    {
        $relativeArtIds = app(SearchInElasticSearchTask::class)->run($searchDto->query, new PictureModel());
        $paginator = PaginatorFactory::create(collect($relativeArtIds));
        if ($paginator->isNotEmpty()) {
            $relativeArtIds = $paginator->getCollection()->toArray();
            $relativeArts = $this->getArtsByIdsAction->run($relativeArtIds);
            $paginator = PaginatorFactory::createFromAnother($paginator, collect($relativeArts));
        }
        return $paginator;
    }
}
