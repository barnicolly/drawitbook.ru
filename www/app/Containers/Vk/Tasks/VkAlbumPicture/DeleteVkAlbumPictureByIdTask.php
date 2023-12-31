<?php

declare(strict_types=1);

namespace App\Containers\Vk\Tasks\VkAlbumPicture;

use App\Containers\Vk\Data\Repositories\VkAlbumPictureRepository;
use App\Ship\Parents\Tasks\Task;

final class DeleteVkAlbumPictureByIdTask extends Task
{
    public function __construct(protected VkAlbumPictureRepository $repository)
    {
    }

    public function run(int $id): void
    {
        $this->repository->delete($id);
    }
}
