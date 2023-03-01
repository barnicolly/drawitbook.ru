<?php

namespace App\Containers\Picture\Tasks\Picture\Cell;

use App\Containers\Picture\Actions\Art\GetArtsByIdsAction;
use App\Containers\Picture\Exceptions\NotFoundRelativeArts;
use App\Containers\Search\Services\SearchService;
use App\Ship\Parents\Tasks\Task;
use App\Ship\Services\Paginator\PaginatorService;

class GetPaginatedCellArtsByTagTask extends Task
{

    private SearchService $searchService;
    private PaginatorService $paginatorService;
    private GetArtsByIdsAction $getArtsByIdsAction;

    public function __construct(
        SearchService $searchService,
        PaginatorService $paginatorService,
        GetArtsByIdsAction $getArtsByIdsAction,
    ) {
        $this->searchService = $searchService;
        $this->paginatorService = $paginatorService;
        $this->getArtsByIdsAction = $getArtsByIdsAction;
    }

    public function run(int $tagId, int $pageNum): array
    {
        //        todo-misha сформировать dto;
        [$relativeArtIds, $countSearchResults, $isLastSlice, $countLeftArts] = $this->formSliceArtIds(
            $tagId,
            $pageNum
        );
        if (!$relativeArtIds) {
            throw new NotFoundRelativeArts();
        }
        $relativeArts = $this->getArtsByIdsAction->run($relativeArtIds);
        $result['countRelatedArts'] = $countSearchResults;
        $result['arts'] = $relativeArts;
        $result['countLeftArts'] = $countLeftArts;
        $result['isLastSlice'] = $isLastSlice;
        $result['page'] = $pageNum;
        return $result;
    }

    private function formSliceArtIds(int $tagId, int $pageNum): array
    {
        $relativePictureIds = $this->searchService
            ->setLimit(1000)
            ->searchByTagId($tagId);
        return $this->paginatorService->formSlice($relativePictureIds, $pageNum);
    }
}


