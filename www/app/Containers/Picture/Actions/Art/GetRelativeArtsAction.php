<?php

namespace App\Containers\Picture\Actions\Art;

use App\Containers\Picture\Services\ArtsService;
use App\Containers\Picture\Tasks\Picture\GetInterestingPictureIdsTask;
use App\Containers\Search\Services\SearchService;
use App\Containers\Tag\Services\TagsService;
use App\Ship\Parents\Actions\Action;

class GetRelativeArtsAction extends Action
{

    private TagsService $tagsService;
    private SearchService $searchService;
    private ArtsService $artsService;
    private GetInterestingPictureIdsTask $getInterestingPictureIdsTask;

    /**
     * @param TagsService $tagsService
     * @param SearchService $searchService
     * @param ArtsService $artsService
     */
    public function __construct(
        TagsService $tagsService,
        SearchService $searchService,
        ArtsService $artsService,
        GetInterestingPictureIdsTask $getInterestingPictureIdsTask
    ) {
        $this->tagsService = $tagsService;
        $this->searchService = $searchService;
        $this->artsService = $artsService;
        $this->getInterestingPictureIdsTask = $getInterestingPictureIdsTask;
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
        }
        if (empty($arts)) {
            $artIds = $this->getInterestingPictureIdsTask->run($artId, 10);
        }
        if (!empty($artIds)) {
            $arts = $this->artsService->getByIdsWithRelations($artIds);
        }
        return $arts;
    }

}


