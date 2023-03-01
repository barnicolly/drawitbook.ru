<?php

namespace App\Containers\Picture\Actions\Art;

use App\Containers\Picture\Tasks\Picture\GetInterestingPictureIdsTask;
use App\Ship\Parents\Actions\Action;
use Prettus\Repository\Exceptions\RepositoryException;

class GetInterestingArtsAction extends Action
{
    private GetInterestingPictureIdsTask $getInterestingPictureIdsTask;
    private GetArtsByIdsAction $getArtsByIdsAction;

    public function __construct(GetInterestingPictureIdsTask $getInterestingPictureIdsTask, GetArtsByIdsAction $getArtsByIdsAction)
    {
        $this->getInterestingPictureIdsTask = $getInterestingPictureIdsTask;
        $this->getArtsByIdsAction = $getArtsByIdsAction;
    }

    /**
     * @param int $excludeId
     * @param int $limit
     * @return array
     * @throws RepositoryException
     */
    public function run(int $excludeId, int $limit): array
    {
        $artIds = $this->getInterestingPictureIdsTask->run($excludeId, $limit);
        return $this->getArtsByIdsAction->run($artIds);
    }

}


