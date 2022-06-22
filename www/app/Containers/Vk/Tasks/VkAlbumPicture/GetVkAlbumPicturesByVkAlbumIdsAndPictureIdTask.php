<?php

namespace App\Containers\Vk\Tasks\VkAlbumPicture;

use App\Containers\Vk\Data\Criteria\VkAlbumPicture\WhereVkAlbumPicturePictureIdCriteria;
use App\Containers\Vk\Data\Criteria\VkAlbumPicture\WhereVkAlbumPictureVkAlbumIdsCriteria;
use App\Containers\Vk\Data\Repositories\VkAlbumPictureRepository;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Collection;

class GetVkAlbumPicturesByVkAlbumIdsAndPictureIdTask extends Task
{

    protected VkAlbumPictureRepository $repository;

    public function __construct(VkAlbumPictureRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(int $pictureId, array $vkAlbumIds): Collection
    {
        $this->repository->pushCriteria(new WhereVkAlbumPicturePictureIdCriteria($pictureId))
            ->pushCriteria(new WhereVkAlbumPictureVkAlbumIdsCriteria($vkAlbumIds));
        return $this->repository->get();
    }
}


