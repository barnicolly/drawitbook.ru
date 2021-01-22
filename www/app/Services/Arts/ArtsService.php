<?php

namespace App\Services\Arts;

use App\Entities\Picture\PictureModel;
use App\Entities\Vk\VkAlbumModel;
use App\Entities\Vk\VkAlbumPictureModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ArtsService
{

    public function getInterestingArts(int $excludeId, int $limit = 10): Collection
    {
        $pictures = PictureModel::take($limit)
            ->where('is_del', '=', 0)
            ->where('id', '!=', $excludeId)
            ->where('in_common', '=', IN_MAIN_PAGE)
            ->with(['tags'])->get();
        $checkExistPictures = new CheckExistPictures($pictures);
        return $checkExistPictures->check();
    }

    public function getById(int $id): ?array
    {
        $art = PictureModel::query()
            ->where('id', $id)
            ->getQuery()
            ->first();
        return $art ? (array) $art : null;
    }

    public function isArtExist(int $id): bool
    {
        return !empty($this->getById($id));
    }

    public function attachArtToVkAlbum(int $artId, int $albumId, int $vkAlbumId): void
    {
        $album = VkAlbumModel::find($albumId);
        $vkAlbumPictureModel = new VkAlbumPictureModel();
        $vkAlbumPictureModel->vk_album_id = $album->id;
        $vkAlbumPictureModel->out_vk_image_id = $vkAlbumId;
        $vkAlbumPictureModel->picture_id = $artId;
        $album->pictures()->save($vkAlbumPictureModel);
    }

    public function getIdForPost(): ?int
    {
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


