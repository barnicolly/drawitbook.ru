<?php

namespace App\Containers\Picture\Services;

use App\Containers\Picture\Models\PictureExtensionsModel;
use App\Containers\Picture\Models\PictureModel;
use App\Containers\Seo\Services\SeoService;
use App\Containers\Tag\Services\TagsService;
use App\Containers\Vk\Models\VkAlbumPictureModel;
use Illuminate\Support\Facades\DB;

class ArtsService
{

    private $tagsService;
    private $seoService;

    public function __construct()
    {
        $this->tagsService = (new TagsService());
        $this->seoService = (new SeoService());
    }

    public function isArtExist(int $id): bool
    {
        return !empty($this->getById($id));
    }

    public function updateVkPosting(int $artId, int $status): bool
    {
        return PictureModel::updateVkPosting($artId, $status);
    }

    public function getInterestingArts(int $excludeId, int $limit): array
    {
        $arts = PictureModel::getInterestingArts($excludeId, $limit);
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
        $art = PictureModel::getById($id);
        if (!empty($art)) {
            $files = $this->getFilesByArtIds([$id]);
            $arts = $this->setFilesOnArts([$art], $files);
            $art = getFirstItemFromArray($arts);
        }
        return $art;
    }

    public function getByIdsWithTags(array $ids): array
    {
        $arts = PictureModel::getByIds($ids);
        return $this->prepareArts($arts);
    }

    private function getFilesByArtIds(array $artIds): array
    {
        return PictureExtensionsModel::getByPictureIds($artIds);
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

    public function getIdForPost(): ?int
    {
        //TODO-misha переписать на query;
        $results = DB::select(
            DB::raw(
                'select picture.id,
  IF(lastPostingDate.dayDiff IS NULL,
     IF((select DATEDIFF(NOW(), MAX(history_vk_posting.created_at)) as dayDiff
         from history_vk_posting
         group by picture_id
         order by dayDiff DESC
         limit 1) <= 10, 10 + 1, (select DATEDIFF(NOW(), MAX(history_vk_posting.created_at)) as dayDiff
                                  from history_vk_posting
                                  group by picture_id
                                  order by dayDiff DESC
                                  limit 1) + 1),
     lastPostingDate.dayDiff
  ) as dayDiff
from picture
  left join (select picture_id,
               MAX(history_vk_posting.created_at) as dateTime,
               COUNT(history_vk_posting.id),
               NOW(),
               DATEDIFF(NOW(), MAX(history_vk_posting.created_at)) as dayDiff
             from history_vk_posting
             group by picture_id) as lastPostingDate on picture.id = lastPostingDate.picture_id
where picture.in_vk_posting = 1
      and (lastPostingDate.dayDiff > 10 or lastPostingDate.dayDiff is null)
group by picture.id
order by dayDiff DESC
limit 1'
            )
        );
        if ($results) {
            return $results[0]->id;
        }
        return null;
    }
}


