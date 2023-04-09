<?php

namespace App\Containers\Search\Actions;

use App\Containers\Picture\Actions\Art\GetArtsByIdsAction;
use App\Containers\Picture\Exceptions\NotFoundRelativeArts;
use App\Containers\Search\Data\Dto\SearchDto;
use App\Containers\Search\Services\SearchService;
use App\Ship\Factories\PaginatorFactory;
use App\Ship\Parents\Actions\Action;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchPicturesAction extends Action
{
    public function __construct(private readonly SearchService $searchService, private readonly GetArtsByIdsAction $getArtsByIdsAction)
    {
    }

    public function run(SearchDto $searchDto): LengthAwarePaginator
    {
        $relativeArtIds = $this->searchService
            ->setLimit(1000)
            ->searchByQuery($searchDto->query);
        $paginator = PaginatorFactory::create(collect($relativeArtIds));
        if ($paginator->isNotEmpty()) {
            $relativeArtIds = $paginator->getCollection()->toArray();
            $relativeArts = $this->getArtsByIdsAction->run($relativeArtIds);
            $paginator = PaginatorFactory::createFromAnother($paginator, collect($relativeArts));
        } else {
            throw new NotFoundRelativeArts();
        }
        return $paginator;
    }

}


