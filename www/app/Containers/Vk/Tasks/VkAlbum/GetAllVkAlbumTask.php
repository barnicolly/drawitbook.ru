<?php

namespace App\Containers\Vk\Tasks\VkAlbum;

use App\Containers\Vk\Data\Repositories\VkAlbumRepository;
use App\Containers\Vk\Models\VkAlbumModel;
use App\Ship\Parents\Tasks\Task;

class GetAllVkAlbumTask extends Task
{

    protected VkAlbumRepository $repository;

    public function __construct(VkAlbumRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return array
     */
    public function run(): array
    {
        $result = $this->repository->all()
            ->toArray();
        return VkAlbumModel::mapToArray($result);
    }
}


