<?php

namespace App\Containers\Vk\Tasks\VkAlbum;

use App\Containers\Vk\Data\Repositories\VkAlbumRepository;
use App\Containers\Vk\Exceptions\NotFoundVkAlbumException;
use App\Containers\Vk\Models\VkAlbumModel;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GetVkAlbumByIdTask extends Task
{

    protected VkAlbumRepository $repository;

    public function __construct(VkAlbumRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $id
     * @return VkAlbumModel
     * @throws NotFoundVkAlbumException
     */
    public function run(int $id): VkAlbumModel
    {
        try {
            return $this->repository->find($id);
        } catch (ModelNotFoundException $exception) {
            throw new NotFoundVkAlbumException();
        }
    }
}


