<?php

declare(strict_types=1);

namespace App\Containers\Vk\Tasks\VkAlbumPicture;

use App\Containers\Vk\Enums\VkAlbumPictureColumnsEnum;
use App\Ship\Parents\Criterias\WhereIntCriteria;
use Prettus\Repository\Exceptions\RepositoryException;
use App\Containers\Vk\Data\Repositories\VkAlbumPictureRepository;
use App\Containers\Vk\Exceptions\NotFoundVkAlbumPictureException;
use App\Containers\Vk\Models\VkAlbumPictureModel;
use App\Ship\Parents\Tasks\Task;

final class GetVkAlbumPictureByVkAlbumIdAndPictureIdTask extends Task
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
        $this->repository->pushCriteria(new WhereIntCriteria(VkAlbumPictureColumnsEnum::PICTURE_ID, $pictureId))
            ->pushCriteria(new WhereIntCriteria(VkAlbumPictureColumnsEnum::VK_ALBUM_ID, $vkAlbumId));
        $result = $this->repository->first();
        if (!$result) {
            throw new NotFoundVkAlbumPictureException();
        }
        return $result;
    }
}
