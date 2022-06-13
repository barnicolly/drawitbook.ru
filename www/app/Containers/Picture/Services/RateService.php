<?php

namespace App\Containers\Picture\Services;

use App\Containers\Picture\Enums\PictureColumnsEnum;
use App\Containers\Picture\Models\PictureModel;
use App\Containers\Rate\Enums\RateEnum;
use App\Containers\Rate\Enums\UserActivityColumnsEnum;
use App\Containers\Rate\Models\UserActivityModel;
use App\Ship\Enums\SoftDeleteStatusEnum;
use App\Ship\Parents\Controllers\HttpController;
use Exception;
use Illuminate\Support\Facades\DB;

class RateService extends HttpController
{

    private $_pictureId;
    private $_userId;
    private $_ip;

    public function __construct(int $pictureId, string $ip, int $userId)
    {
        //TODO-misha вынести работу с бд в отдельный слой;
        $this->_pictureId = $pictureId;
        $this->_ip = $ip;
        $this->_userId = !empty($userId) ? $userId : 0;
    }

    public function like(bool $turnOn)
    {
        $this->_checkPictureExist();
        $this->_rate($turnOn, RateEnum::LIKE);
    }

    public function dislike(bool $turnOn)
    {
        $this->_checkPictureExist();
        $this->_rate($turnOn, RateEnum::DISLIKE);
    }

    private function _rate(bool $turnOn, int $rate)
    {
        $activity = $this->_getActivityIfExist();
        if (!$activity && $turnOn) {
            $activity = new UserActivityModel();
            $activity->picture_id = $this->_pictureId;
            $activity->ip = DB::raw("inet_aton($this->_ip)");
            $activity->user_id = $this->_userId;
        }
        if ($activity) {
            $activity->is_del = $turnOn ? SoftDeleteStatusEnum::FALSE : SoftDeleteStatusEnum::TRUE;
            $activity->activity = $rate;
            $activity->save();
        }
        return true;
    }

    private function _getActivityIfExist()
    {
        $activity = UserActivityModel::whereIn(UserActivityColumnsEnum::ACTIVITY, [RateEnum::LIKE, RateEnum::DISLIKE])
            ->where(UserActivityColumnsEnum::PICTURE_ID, '=', $this->_pictureId);
        ($this->_userId)
            ? $activity->where(UserActivityColumnsEnum::USER_ID, '=', $this->_userId)
            : $activity->whereRaw("INET_NTOA(" . UserActivityColumnsEnum::IP . ") = $this->_ip");
        return $activity->first();
    }

    /**
     * @return void
     * @throws Exception
     */
    private function _checkPictureExist(): void
    {
//        todo-misha вынести;
        $picture = PictureModel::where(PictureColumnsEnum::IS_DEL, '=', SoftDeleteStatusEnum::FALSE)
            ->find($this->_pictureId);
        if (!$picture) {
            throw new Exception('Запись с изображением не найдена или была удалена');
        }
    }

}
