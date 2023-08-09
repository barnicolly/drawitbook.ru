<?php

declare(strict_types=1);

namespace App\Containers\Picture\Tasks\Picture;

use App\Containers\Picture\Enums\PictureColumnsEnum;
use App\Containers\Picture\Models\PictureModel;
use App\Containers\Tag\Enums\TagsColumnsEnum;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Contracts\Database\Query\Builder as BuilderContract;
use Illuminate\Pagination\LengthAwarePaginator;

class GetPaginatedPicturesIdsByTagIdTask extends Task
{
    public function run(int $tagId, int $perPage): LengthAwarePaginator
    {
        return PictureModel::whereHas('tags', static function (BuilderContract $q) use ($tagId): void {
            $q->where(TagsColumnsEnum::tID, $tagId);
        })
            ->paginate($perPage, [PictureColumnsEnum::ID]);
    }
}
