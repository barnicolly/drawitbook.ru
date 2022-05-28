<?php

namespace App\Containers\Picture\Services;

use App\Containers\Picture\Models\PictureModel;
use App\Entities\User\UserActivityModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RateService extends Controller
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
        $this->_rate($turnOn, LIKE);
    }

    public function dislike(bool $turnOn)
    {
        $this->_checkPictureExist();
        $this->_rate($turnOn, DISLIKE);
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
            $activity->is_del = $turnOn ? NON_DELETED_ROW : DELETED_ROW;
            $activity->activity = $rate;
            $activity->save();
        }
        return true;
    }

    private function _getActivityIfExist()
    {
        $activity = UserActivityModel::whereIn('activity', [LIKE, DISLIKE])
            ->where('picture_id', '=', $this->_pictureId);
        ($this->_userId)
            ? $activity->where('user_id', '=', $this->_userId)
            : $activity->whereRaw("INET_NTOA(ip) = $this->_ip");
        return $activity->first();
    }

    private function _checkPictureExist()
    {
        $picture = PictureModel::where('is_del', '=', NON_DELETED_ROW)
            ->find($this->_pictureId);
        if (!$picture) {
            throw new \Exception('Запись с изображением не найдена или была удалена');
        }
    }

}
