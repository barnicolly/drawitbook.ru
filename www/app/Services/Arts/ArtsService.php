<?php

namespace App\Services\Arts;

use App\Entities\Picture\PictureModel;
use App\Entities\Vk\VkAlbumModel;
use App\Entities\Vk\VkAlbumPictureModel;
use App\Services\Seo\SeoService;
use App\Services\Tags\TagsService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    public function checkExistArts(array $arts): array
    {
        foreach ($arts as $key => $art) {
            if (!checkExistArt($art['path'])) {
                unset($arts[$key]);
                Log::info('Не найдено изображение', ['art' => $art]);
            }
        }
        return $arts;
    }

    public function getById(int $id): ?array
    {
        return PictureModel::getById($id);
    }

    public function getByIdsWithTags(array $ids): array
    {
        $arts = PictureModel::getByIds($ids);
        return $this->prepareArts($arts);
    }

    private function prepareArts(array $arts): array
    {
        $arts = $this->checkExistArts($arts);
        $artIds = array_column($arts, 'id');
        $tags = $this->tagsService->getTagsByArtIds($artIds, false);
        $tags = $this->tagsService->setLinkOnTags($tags);
        $arts = $this->setTagsOnArts($arts, $tags);
        $arts = $this->seoService->setArtsAlt($arts);
        return $arts;
    }

    public function attachArtToVkAlbum(int $artId, int $albumId, int $vkAlbumId): void
    {
        //TODO-misha отрефакторить;
        $album = VkAlbumModel::find($albumId);
        $vkAlbumPictureModel = new VkAlbumPictureModel();
        $vkAlbumPictureModel->vk_album_id = $album->id;
        $vkAlbumPictureModel->out_vk_image_id = $vkAlbumId;
        $vkAlbumPictureModel->picture_id = $artId;
        $album->pictures()->save($vkAlbumPictureModel);
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


