<?php

namespace App\Containers\Picture\Actions\Art;

use App\Containers\Picture\Tasks\Picture\GetInterestingPictureIdsTask;
use App\Containers\Search\Services\SearchService;
use App\Containers\Tag\Tasks\SeparateTagsForHiddenAndShowIdsTask;
use App\Ship\Parents\Actions\Action;
use Prettus\Repository\Exceptions\RepositoryException;

class GetRelativeArtsAction extends Action
{

    public function __construct(private readonly SearchService $searchService, private readonly GetInterestingPictureIdsTask $getInterestingPictureIdsTask, private readonly SeparateTagsForHiddenAndShowIdsTask $separateTagsForHiddenAndShowIdsTask, private readonly GetArtsByIdsAction $getArtsByIdsAction)
    {
    }

    /**
     * @throws RepositoryException
     */
    public function run(array $artTags, int $artId): array
    {
        [$shown, $hidden] = $this->separateTagsForHiddenAndShowIdsTask->run($artTags);
        $arts = [];
        if ($shown || $hidden) {
            $artIds = $this->searchService->searchRelatedPicturesIds($shown, $hidden, $artId);
        }
        if (empty($artIds)) {
            $artIds = $this->getInterestingPictureIdsTask->run($artId, 10);
        }
        if (!empty($artIds)) {
            $arts = $this->getArtsByIdsAction->run($artIds);
        }
        return $arts;
    }

}


