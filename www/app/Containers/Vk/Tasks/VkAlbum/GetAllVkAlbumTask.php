<?php

declare(strict_types=1);

namespace App\Containers\Vk\Tasks\VkAlbum;

use App\Containers\Vk\Data\Repositories\VkAlbumRepository;
use App\Containers\Vk\Models\VkAlbumModel;
use App\Ship\Parents\Tasks\Task;

class GetAllVkAlbumTask extends Task
{
    public function __construct(protected VkAlbumRepository $repository)
    {
    }

    public function run(): array
    {
        $result = $this->repository->all()
            ->toArray();
        return VkAlbumModel::mapToArray($result);
    }
}
