<?php

namespace App\Containers\Search\Actions;

use App\Containers\Picture\Exceptions\NotFoundRelativeArts;
use App\Containers\Picture\Services\ArtsService;
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
     * @param array $filters
     * @param int $pageNum
     * @return array{array, int, bool, int}
     */
    public function run(array $filters, int $pageNum): array
    {
        //        todo-misha обработать заранее;
        $query = !empty($filters['query']) ? strip_tags($filters['query']) : '';
        $relativeArtIds = [];
        try {
            if ($query) {
                $relativeArtIds = $this->searchService
                    ->setLimit(1000)
                    ->searchByQuery($query);
            }
            if ($relativeArtIds) {
                [$relativeArtIds, $countSearchResults, $isLastSlice, $countLeftArts] = $this->paginatorService->formSlice(
                    $relativeArtIds,
                    $pageNum
                );
                if (!$relativeArtIds) {
                    throw new NotFoundRelativeArts();
                }
                $relativeArts = $this->artsService->getByIdsWithTags($relativeArtIds);
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


