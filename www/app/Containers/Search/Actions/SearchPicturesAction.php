<?php

namespace App\Containers\Search\Actions;

use App\Containers\Picture\Exceptions\NotFoundRelativeArts;
use App\Containers\Picture\Services\ArtsService;
use App\Containers\Search\Data\Dto\SearchDto;
use App\Containers\Search\Services\SearchService;
use App\Ship\Parents\Actions\Action;
use App\Ship\Services\Paginator\PaginatorService;

class SearchPicturesAction extends Action
{
    private ArtsService $artsService;
    private SearchService $searchService;
    private PaginatorService $paginatorService;

    public function __construct(
        SearchService $searchService,
        PaginatorService $paginatorService,
        ArtsService $artsService,
    ) {
        $this->artsService = $artsService;
        $this->searchService = $searchService;
        $this->paginatorService = $paginatorService;
    }

    /**
     * @param SearchDto $searchDto
     * @param int $pageNum
     * @return array{array, int, bool, int}
     */
    public function run(SearchDto $searchDto, int $pageNum): array
    {
        try {
            $relativeArtIds = $this->searchService
                ->setLimit(1000)
                ->searchByQuery($searchDto->query);
            if ($relativeArtIds) {
                [
                    $relativeArtIds,
                    $countSearchResults,
                    $isLastSlice,
                    $countLeftArts,
                ] = $this->paginatorService->formSlice(
                    $relativeArtIds,
                    $pageNum
                );
                if (!$relativeArtIds) {
                    throw new NotFoundRelativeArts();
                }
                $relativeArts = $this->artsService->getByIdsWithRelations($relativeArtIds);
            } else {
                throw new NotFoundRelativeArts();
            }
        } catch (NotFoundRelativeArts $e) {
            $relativeArts = [];
            $countSearchResults = 0;
        }
        $isLastSlice = $isLastSlice ?? false;
        $countLeftArts = $countLeftArts ?? 0;
        return [$relativeArts, $countSearchResults, $isLastSlice, $countLeftArts];
    }

}


