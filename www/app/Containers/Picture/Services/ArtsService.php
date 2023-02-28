<?php

namespace App\Containers\Picture\Services;

use App\Containers\Picture\Exceptions\NotFoundPicture;
use App\Containers\Picture\Tasks\Picture\FormPictureDtoTask;
use App\Containers\Picture\Tasks\Picture\GetInterestingPictureIdsTask;
use App\Containers\Picture\Tasks\Picture\GetPicturesByIdsTask;

//todo-misha разнести по таскам;
class ArtsService
{

    public function getInterestingArtsWithRelations(int $excludeId, int $limit): array
    {
        $artIds = app(GetInterestingPictureIdsTask::class)->run($excludeId, $limit);
        return $this->getByIdsWithRelations($artIds);
    }

    /**
     * @param int $id
     * @return array|null
     */
    public function getById(int $id, bool $withHiddenTags = false): ?array
    {
        $arts = $this->getByIdsWithRelations([$id], $withHiddenTags);
        $art = getFirstItemFromArray($arts);
        if (!$art) {
            throw new NotFoundPicture();
        }
        return $art;
    }

    public function getByIdsWithRelations(array $ids, bool $withHiddenTags = false): array
    {
        $arts = app(GetPicturesByIdsTask::class)->run($ids, $withHiddenTags);
        return app(FormPictureDtoTask::class)->run($arts);
    }
}


