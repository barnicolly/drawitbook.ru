<?php

namespace App\Containers\Vk\Tasks\VkAlbumPicture;

use App\Containers\Vk\Data\Repositories\VkAlbumPictureRepository;
use App\Containers\Vk\Enums\VkAlbumPictureColumnsEnum;
use App\Ship\Parents\Criterias\WhereIntCriteria;
use App\Ship\Parents\Criterias\WhereArrayCriteria;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Collection;

class GetVkAlbumPicturesByVkAlbumIdsAndPictureIdTask extends Task
{
    public function __construct(protected VkAlbumPictureRepository $repository)
    {
    }

    public function run(int $pictureId, array $vkAlbumIds): Collection
    {
        $this->repository->pushCriteria(new WhereIntCriteria(VkAlbumPictureColumnsEnum::PICTURE_ID, $pictureId))
            ->pushCriteria(new WhereArrayCriteria(VkAlbumPictureColumnsEnum::VK_ALBUM_ID, $vkAlbumIds));
        return $this->repository->get();
    }
}
