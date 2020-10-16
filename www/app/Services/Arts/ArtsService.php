<?php

namespace App\Services\Arts;

use App\Entities\Picture\PictureModel;
use Illuminate\Database\Eloquent\Collection;

class ArtsService
{

    public function getInterestingArts(int $excludeId, int $limit = 10): Collection
    {
        $pictures = PictureModel::take($limit)
            ->where('is_del', '=', 0)
            ->where('id', '!=', $excludeId)
            ->where('in_common', '=', IN_MAIN_PAGE)
            ->with(['tags'])->get();
        $checkExistPictures = new CheckExistPictures($pictures);
        return $checkExistPictures->check();
    }

    public function getById(int $id): ?array
    {
        $art = PictureModel::query()
            ->where('id', $id)
            ->getQuery()
            ->first();
        return $art ? (array) $art : null;
    }

    public function isArtExist(int $id): bool
    {
        return !empty($this->getById($id));
    }
}


