<?php

namespace App\Containers\Picture\Actions\Art;

use App\Containers\Picture\Models\PictureModel;
use App\Containers\Picture\Tasks\Picture\GetInterestingPictureIdsTask;
use App\Containers\Search\Tasks\SearchInElasticSearchTask;
use App\Ship\Parents\Actions\Action;

class GetRelativeArtsAction extends Action
{
    public function __construct(
        private readonly GetInterestingPictureIdsTask $getInterestingPictureIdsTask,
        private readonly GetArtsByIdsAction $getArtsByIdsAction,
    ) {
    }

    public function run(array $artTags, int $artId): array
    {
        $names = array_column($artTags, 'name');
        if ($names) {
            $artIds = app(SearchInElasticSearchTask::class)->run(implode(' ', $names), new PictureModel(), app()->getLocale(), 16);
            $artIds = array_diff($artIds, [$artId]);
        }
        if (empty($artIds)) {
            $artIds = $this->getInterestingPictureIdsTask->run($artId, 10);
        }
        $arts = [];
        if (!empty($artIds)) {
            $arts = $this->getArtsByIdsAction->run($artIds);
        }
        return $arts;
    }
}
