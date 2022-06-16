<?php

namespace App\Containers\Picture\Actions\Art;

use App\Containers\Picture\Services\ArtsService;
use App\Containers\Search\Services\SearchService;
use App\Containers\Tag\Services\TagsService;
use App\Ship\Parents\Actions\Action;

class GetRelativeArtsAction extends Action
{

    private TagsService $tagsService;
    private SearchService $searchService;
    private ArtsService $artsService;

    /**
     * @param TagsService $tagsService
     * @param SearchService $searchService
     * @param ArtsService $artsService
     */
    public function __construct(TagsService $tagsService, SearchService $searchService, ArtsService $artsService)
    {
        $this->tagsService = $tagsService;
        $this->searchService = $searchService;
        $this->artsService = $artsService;
    }

    /**
     * @param array $artTags
     * @param int $artId
     * @return array
     */
    public function run(array $artTags, int $artId): array
    {
        [$shown, $hidden] = $this->tagsService->separateTagsForHiddenAndShowIds($artTags);
        $arts = [];
        if ($shown || $hidden) {
            $artIds = $this->searchService->searchRelatedPicturesIds($shown, $hidden, $artId);
            if (!empty($artIds)) {
                $arts = $this->artsService->getByIdsWithTags($artIds);
            }
        }
        if (empty($arts)) {
            $arts = $this->artsService->getInterestingArts($artId, 10);
        }
        return $arts;
    }

}


