<?php

namespace App\Containers\Picture\Services;

use App\Containers\Picture\Enums\PictureExtensionsColumnsEnum;
use App\Containers\Picture\Tasks\Picture\GetInterestingPicturesTask;
use App\Containers\Picture\Tasks\Picture\GetPictureByIdTask;
use App\Containers\Picture\Tasks\Picture\GetPicturesByIdsTask;
use App\Containers\Picture\Tasks\Picture\UpdatePictureVkPostingStatusTask;
use App\Containers\Picture\Tasks\PictureExtension\GetPictureExtensionsByPictureIdsTask;
use App\Containers\Seo\Services\SeoService;
use App\Containers\Tag\Services\TagsService;
use App\Containers\Vk\Models\VkAlbumPictureModel;

class ArtsService
{

    private $tagsService;
    private $seoService;

    public function __construct()
    {
        $this->tagsService = (new TagsService());
        $this->seoService = (new SeoService());
    }

//    todo-misha проверить использование;
    public function isArtExist(int $id): bool
    {
        return !empty($this->getById($id));
    }

    public function updateVkPosting(int $artId, int $status): bool
    {
        return app(UpdatePictureVkPostingStatusTask::class)->run($artId, $status);
    }

    public function getInterestingArts(int $excludeId, int $limit): array
    {
        $arts = app(GetInterestingPicturesTask::class)->run($excludeId, $limit);
        return $this->prepareArts($arts);
    }

    private function setTagsOnArts(array $arts, array $tags): array
    {
        $tags = groupArray($tags, 'picture_id');
        foreach ($arts as $key => $art) {
            $artId = $art['id'];
            $arts[$key]['tags'] = $tags[$artId] ?? [];
        }
        return $arts;
    }

    public function getById(int $id): ?array
    {
        $art = app(GetPictureByIdTask::class)->run($id);
        if (!empty($art)) {
            $files = $this->getFilesByArtIds([$id]);
            $arts = $this->setFilesOnArts([$art], $files);
            $art = getFirstItemFromArray($arts);
        }
        return $art;
    }

    public function getByIdsWithTags(array $ids): array
    {
        $arts = app(GetPicturesByIdsTask::class)->run($ids);
        return $this->prepareArts($arts);
    }

    private function getFilesByArtIds(array $artIds): array
    {
        $result = app(GetPictureExtensionsByPictureIdsTask::class)->run($artIds);
        return groupArray($result, PictureExtensionsColumnsEnum::PICTURE_ID);
    }

    private function prepareArts(array $arts): array
    {
        $artIds = array_column($arts, 'id');
        $files = $this->getFilesByArtIds($artIds);
        $arts = $this->setFilesOnArts($arts, $files);
        $tags = $this->tagsService->getTagsByArtIds($artIds, false);
        $tags = $this->tagsService->setLinkOnTags($tags);
        $arts = $this->setTagsOnArts($arts, $tags);
        $arts = $this->seoService->setArtsAlt($arts);
        return $arts;
    }

    private function setFilesOnArts(array $arts, array $files): array
    {
        foreach ($arts as $key => $art) {
            $artId = $art['id'];
            if (!empty($files[$artId])) {
                $artFiles = $files[$artId];
                $mainArt = null;
                $optimizedArt = null;
                foreach ($artFiles as $file) {
                    $file['fs_path'] = formArtFsPath($file['path']);
                    if ($file['ext'] === 'webp') {
                        $optimizedArt = $file;
                    } else {
                        $mainArt = $file;
                    }
                }
                $arts[$key]['images'] = [
                   'primary' => $mainArt ?? '',
                   'optimized' => $optimizedArt ?? '',
                ];
            }
        }
        return $arts;
    }

    public function attachArtToVkAlbum(int $artId, int $albumId, int $vkAlbumId): void
    {
        $data = [
            'vk_album_id' => $albumId,
            'out_vk_image_id' => $vkAlbumId,
            'picture_id' => $artId,
        ];
        VkAlbumPictureModel::create($data);
    }
}


