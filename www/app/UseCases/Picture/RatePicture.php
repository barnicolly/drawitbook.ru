<?php

namespace App\UseCases\Picture;

use App\Entities\Picture\PictureModel;
use App\Entities\User\UserActivityModel;
use App\Http\Controllers\Controller;

class RatePicture extends Controller
{

    private $_pictureId;
    private $_userId;
    private $_ip;

    public function __construct(int $pictureId, string $inetAtonIp, int $userId)
    {
        $this->_pictureId = $pictureId;
        $this->_ip = $inetAtonIp;
        $this->_userId = !empty($userId) ? $userId : 0;
    }

    public function rate(bool $status, bool $rate)
    {
        $this->_checkPictureExist();
        if ($activity = $this->_getActivityIfExist()) {
            if (!$off) {
                $activity->activity = $like ? 1 : 2;
                $activity->is_del = 0;
            } else {
                $activity->is_del = 1;
            }
        } else {
            if (!$off) {
                $activity = UserActivityModel::create();
                $activity->picture_id = $picture->id;
                $activity->ip = DB::raw("inet_aton($ip)");
                $activity->activity = $like ? 1 : 2;
                $activity->user_id = auth()->id();
            }
        }
        if ($activity !== null) {
            $activity->save();
        }
        return true;
    }

    private function _getActivityIfExist()
    {
        $activity = UserActivityModel::whereIn('activity', [LIKE, DISLIKE])
            ->where('picture_id', '=', $this->_pictureId);
        ($this->_userId)
            ? $activity->where('user_id', '=', auth()->id())
            : $activity->whereRaw("ip = $this->_ip");
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
