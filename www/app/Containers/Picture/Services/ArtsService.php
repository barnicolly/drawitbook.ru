<?php

namespace App\Containers\Picture\Services;

use App\Containers\Picture\Tasks\Picture\GetInterestingPicturesTask;
use App\Containers\Picture\Tasks\Picture\GetPictureByIdTask;
use App\Containers\Picture\Tasks\Picture\GetPicturesByIdsTask;
use App\Containers\Picture\Tasks\PictureExtension\GetPictureExtensionsByPictureIdsTask;
use App\Containers\Picture\Tasks\PictureExtension\SetPictureExtensionsOnPicturesTask;
use App\Containers\Picture\Tasks\PictureTag\SetPictureTagsOnPicturesTask;
use App\Containers\Seo\Services\SeoService;

class ArtsService
{

    private SeoService $seoService;

    public function __construct()
    {
        $this->seoService = app(SeoService::class);
    }

    public function getInterestingArts(int $excludeId, int $limit): array
    {
        $arts = app(GetInterestingPicturesTask::class)->run($excludeId, $limit);
        return $this->prepareArts($arts);
    }

    /**
     * @param int $id
     * @return array|null
     * @throws \App\Containers\Picture\Exceptions\NotFoundPicture
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function getById(int $id): ?array
    {
//        todo-misha преобразовать в dto;
        $art = app(GetPictureByIdTask::class)->run($id);
        $files = app(GetPictureExtensionsByPictureIdsTask::class)->run([$id]);
        $arts = app(SetPictureExtensionsOnPicturesTask::class)->run([$art], $files);
        return getFirstItemFromArray($arts);
    }

    public function getByIdsWithTags(array $ids): array
    {
        $arts = app(GetPicturesByIdsTask::class)->run($ids);
        return $this->prepareArts($arts);
    }

    private function prepareArts(array $arts): array
    {
        $artIds = array_column($arts, 'id');
        $files = app(GetPictureExtensionsByPictureIdsTask::class)->run($artIds);
        $arts = app(SetPictureExtensionsOnPicturesTask::class)->run($arts, $files);
        $arts = app(SetPictureTagsOnPicturesTask::class)->run($arts);
        foreach ($arts as $index => $art) {
            if (!empty($art['flags'])) {
                $arts[$index]['flags'] = array_column($art['flags'], 'name');
            }
        }
        return $this->seoService->setArtsAlt($arts);
    }
}


