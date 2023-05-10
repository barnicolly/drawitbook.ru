<?php

namespace App\Containers\Like\Tests\Traits;

use App\Containers\Picture\Models\PictureModel;
use App\Containers\Like\Enums\LikesColumnsEnum;
use App\Containers\Like\Models\LikesModel;
use App\Containers\User\Tasks\GetUserIpFromRequestTask;
use Illuminate\Support\Facades\DB;

trait CreateLikesTrait
{
    public function createLike(PictureModel $picture, array $data = []): LikesModel
    {
        $ip = app(GetUserIpFromRequestTask::class)->run();
        $data = array_merge($data, [
            LikesColumnsEnum::PICTURE_ID => $picture->id,
            LikesColumnsEnum::IP => DB::raw("inet_aton({$ip})"),
        ]);
        return LikesModel::factory()->create($data);
    }
}
