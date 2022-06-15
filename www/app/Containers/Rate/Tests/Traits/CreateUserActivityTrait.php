<?php

namespace App\Containers\Rate\Tests\Traits;

use App\Containers\Picture\Models\PictureModel;
use App\Containers\Rate\Enums\UserActivityColumnsEnum;
use App\Containers\Rate\Models\UserActivityModel;
use App\Containers\User\Services\UserService;
use Illuminate\Support\Facades\DB;

trait CreateUserActivityTrait
{

    public function createUserActivity(PictureModel $picture, array $data = []): UserActivityModel
    {
        $ip = app(UserService::class)->getIp();
        $data = array_merge($data, [
            UserActivityColumnsEnum::PICTURE_ID => $picture->id,
            UserActivityColumnsEnum::IP => DB::raw("inet_aton($ip)"),
        ]);
        return UserActivityModel::factory()->create($data);
    }
}
