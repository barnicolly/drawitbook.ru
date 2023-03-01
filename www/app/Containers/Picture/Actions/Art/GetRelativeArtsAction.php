<?php

namespace App\Containers\Picture\Actions\Art;

use App\Containers\Picture\Services\ArtsService;
use App\Containers\Picture\Tasks\Picture\GetInterestingPictureIdsTask;
use App\Containers\Search\Services\SearchService;
use App\Containers\Tag\Tasks\SeparateTagsForHiddenAndShowIdsTask;
use App\Ship\Parents\Actions\Action;
use Prettus\Repository\Exceptions\RepositoryException;

class GetRelativeArtsAction extends Action
{

    private SearchService $searchService;
    private ArtsService $artsService;
    private GetInterestingPictureIdsTask $getInterestingPictureIdsTask;
    private SeparateTagsForHiddenAndShowIdsTask $separateTagsForHiddenAndShowIdsTask;

    public function __construct(
        SearchService $searchService,
        ArtsService $artsService,
        GetInterestingPictureIdsTask $getInterestingPictureIdsTask,
        SeparateTagsForHiddenAndShowIdsTask $separateTagsForHiddenAndShowIdsTask
    ) {
        $this->searchService = $searchService;
        $this->artsService = $artsService;
        $this->getInterestingPictureIdsTask = $getInterestingPictureIdsTask;
        $this->separateTagsForHiddenAndShowIdsTask = $separateTagsForHiddenAndShowIdsTask;
    }

    /**
     * @param array $artTags
     * @param int $artId
     * @return array
     * @throws RepositoryException
     */
    public function run(array $artTags, int $artId): array
    {
        [$shown, $hidden] = $this->separateTagsForHiddenAndShowIdsTask->run($artTags);
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


