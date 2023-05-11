<?php

namespace App\Containers\Picture\Actions\Art;

use App\Containers\Picture\Tasks\Picture\GetInterestingPictureIdsTask;
use App\Ship\Parents\Actions\Action;
use Prettus\Repository\Exceptions\RepositoryException;

class GetInterestingArtsAction extends Action
{
    public function __construct(
        private readonly GetInterestingPictureIdsTask $getInterestingPictureIdsTask,
        private readonly GetArtsByIdsAction $getArtsByIdsAction,
    ) {
    }

    /**
     * @throws RepositoryException
     */
    public function run(int $excludeId, int $limit): array
    {
        $artIds = $this->getInterestingPictureIdsTask->run($excludeId, $limit);
        return $this->getArtsByIdsAction->run($artIds);
    }
}
