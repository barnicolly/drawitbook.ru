<?php

namespace App\Containers\Vk\Tasks\VkAlbumPicture;

use App\Containers\Vk\Data\Repositories\VkAlbumPictureRepository;
use App\Ship\Parents\Tasks\Task;

class DeleteVkAlbumPictureByIdTask extends Task
{

    protected VkAlbumPictureRepository $repository;

    public function __construct(VkAlbumPictureRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $id
     * @return void
     */
    public function run(int $id): void
    {
        $this->repository->delete($id);
    }
}


