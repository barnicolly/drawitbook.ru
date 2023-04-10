<?php

namespace App\Containers\Vk\Tasks\VkAlbumPicture;

use Prettus\Repository\Exceptions\RepositoryException;
use App\Containers\Vk\Data\Criteria\VkAlbumPicture\WhereVkAlbumPicturePictureIdCriteria;
use App\Containers\Vk\Data\Criteria\VkAlbumPicture\WhereVkAlbumPictureVkAlbumIdCriteria;
use App\Containers\Vk\Data\Repositories\VkAlbumPictureRepository;
use App\Containers\Vk\Exceptions\NotFoundVkAlbumPictureException;
use App\Containers\Vk\Models\VkAlbumPictureModel;
use App\Ship\Parents\Tasks\Task;

class GetVkAlbumPictureByVkAlbumIdAndPictureIdTask extends Task
{
    public function __construct(protected VkAlbumPictureRepository $repository)
    {
    }

    /**
     * @throws NotFoundVkAlbumPictureException
     * @throws RepositoryException
     */
    public function run(int $vkAlbumId, int $pictureId): VkAlbumPictureModel
    {
        $this->repository->pushCriteria(new WhereVkAlbumPicturePictureIdCriteria($pictureId))
            ->pushCriteria(new WhereVkAlbumPictureVkAlbumIdCriteria($vkAlbumId));
        $result = $this->repository->first();
        if (!$result) {
            throw new NotFoundVkAlbumPictureException();
        }
        return $result;
    }
}
