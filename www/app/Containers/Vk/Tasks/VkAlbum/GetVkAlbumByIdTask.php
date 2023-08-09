<?php

declare(strict_types=1);

namespace App\Containers\Vk\Tasks\VkAlbum;

use App\Containers\Vk\Data\Repositories\VkAlbumRepository;
use App\Containers\Vk\Exceptions\NotFoundVkAlbumException;
use App\Containers\Vk\Models\VkAlbumModel;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GetVkAlbumByIdTask extends Task
{
    public function __construct(protected VkAlbumRepository $repository)
    {
    }

    /**
     * @throws NotFoundVkAlbumException
     */
    public function run(int $id): VkAlbumModel
    {
        try {
            return $this->repository->find($id);
        } catch (ModelNotFoundException) {
            throw new NotFoundVkAlbumException();
        }
    }
}
