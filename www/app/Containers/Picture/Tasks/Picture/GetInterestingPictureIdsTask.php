<?php

declare(strict_types=1);

namespace App\Containers\Picture\Tasks\Picture;

use App\Containers\Picture\Enums\PictureColumnsEnum;
use App\Containers\Picture\Models\PictureModel;
use App\Ship\Enums\FlagsEnum;
use App\Ship\Parents\Tasks\Task;

class GetInterestingPictureIdsTask extends Task
{
    public function run(int $excludeId, int $limit): array
    {
        return PictureModel::take($limit)
            ->where(PictureColumnsEnum::tId, '!=', $excludeId)
            ->flagged(FlagsEnum::PICTURE_COMMON)
            ->get()
            ->pluck(PictureColumnsEnum::ID)
            ->toArray();
    }
}
