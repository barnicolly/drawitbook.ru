<?php

namespace App\Containers\Picture\Tasks\Picture\Cell;

use App\Containers\Picture\Exceptions\NotFoundRelativeArts;
use App\Containers\Picture\Services\ArtsService;
use App\Containers\Search\Services\SearchService;
use App\Ship\Parents\Tasks\Task;
use App\Ship\Services\Paginator\PaginatorService;

class GetPaginatedCellArtsByTagTask extends Task
{

    private ArtsService $artsService;
    private SearchService $searchService;
    private PaginatorService $paginatorService;

    public function __construct(
        ArtsService $artsService,
        SearchService $searchService,
        PaginatorService $paginatorService
    ) {
        $this->artsService = $artsService;
        $this->searchService = $searchService;
        $this->paginatorService = $paginatorService;
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
        $relativeArts = $this->artsService->getByIdsWithTags($relativeArtIds);
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


