<?php

namespace App\Containers\Picture\Services;

use App\Containers\Picture\Data\Dto\ArtDto;
use App\Containers\Picture\Data\PictureDtoBuilder;
use App\Containers\Picture\Exceptions\NotFoundPicture;
use App\Containers\Picture\Tasks\Picture\FormPicturesDtoTask;
use App\Containers\Picture\Tasks\Picture\GetInterestingPictureIdsTask;
use App\Containers\Picture\Tasks\Picture\GetPictureByIdTask;
use App\Containers\Picture\Tasks\Picture\GetPicturesByIdsTask;
use Prettus\Repository\Exceptions\RepositoryException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

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
     * @param bool $withHiddenTags
     * @return array|null
     * @throws NotFoundPicture
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

    /**
     * @param int $id
     * @return ArtDto
     * @throws NotFoundPicture
     * @throws RepositoryException
     * @throws UnknownProperties
     */
    public function getByIdWithFiles(int $id): ArtDto
    {
        $art = app(GetPictureByIdTask::class)->run($id);
        if (!$art) {
            throw new NotFoundPicture();
        }
        $art->load(['extensions']);
        return (new PictureDtoBuilder($art))
            ->setFiles($art->extensions)
            ->build();
    }

    public function getByIdsWithRelations(array $ids, bool $withHiddenTags = false): array
    {
        $arts = app(GetPicturesByIdsTask::class)->run($ids, $withHiddenTags);
        return app(FormPicturesDtoTask::class)->run($arts);
    }
}


