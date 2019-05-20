<?php

namespace App\Http\Modules\Open\Controllers\Picture;

use App\Http\Controllers\Controller;

//use App\Http\Modules\Database\Models\Common\Picture\PictureModel;
//use App\Http\Modules\Database\Models\Common\User\UserActivityModel;
use App\UseCases\Picture\RatePicture;
use App\UseCases\User\GetIp;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Validation\Rule;

class Rate extends Controller
{

    protected $_errorJsonResponse;
    protected $_successJsonResponse;

    public function __construct()
    {
        $this->_errorJsonResponse = [
            'success' => false,
        ];
        $this->_successJsonResponse = [
            'success' => true,
        ];
    }

    public function likeJson($id, Request $request)
    {
        $data = ['id' => $id, 'off' => $request->input('off')];
        try {
            $this->_validate($data);
            $ip = request()->ip();
            $getIp = new GetIp($ip);

            $ratePicture = new RatePicture($data['id'], $getIp->inetAton(), auth()->id());

//            $ip = DB::connection()->getPdo()->quote($ip);

        } catch (\Throwable $e) {
            return response($this->_errorJsonResponse);
        }
//        $this->_createOrModifyUserActivity($picture, true, $data['off'] === 'true');
        return response($this->_successJsonResponse);
    }

    public function dislikeJson($id, Request $request)
    {
        $data = ['id' => $id, 'off' => $request->input('off')];
        return $this->_compareUserActivity($data, false);
    }

 /*   private function _compareUserActivity(array $data, bool $like)
    {
        $result['success'] = false;
        if (!$this->_validate($data)) {
            return response($result);
        }
        $picture = PictureModel::find($data['id']);
        if ($picture === null) {
            return response($result);
        }
        $this->_createOrModifyUserActivity($picture, $like, $data['off'] === 'true');
        $result['success'] = true;
        return response($result);
    }

    private function _createOrModifyUserActivity(PictureModel $picture, bool $like, bool $off): bool
    {
        $ip = request()->ip();
        $ip = DB::connection()->getPdo()->quote($ip);
        if (auth()->check()) {
            $activity = UserActivityModel::whereIn('activity', [1, 2])
                ->where('user_id', '=', auth()->id())
                ->where('picture_id', '=', $picture->id)
                ->first();
        } else {
            $activity = UserActivityModel::whereIn('activity', [1, 2])
                ->whereRaw("ip = inet_aton($ip)")
                ->where('picture_id', '=', $picture->id)
                ->first();
        }
        if ($activity === null) {
            if (!$off) {
                $activity = UserActivityModel::create();
                $activity->picture_id = $picture->id;
                $activity->ip = DB::raw("inet_aton($ip)");
                $activity->activity = $like ? 1 : 2;
                $activity->user_id = auth()->id();
            }
        } else {
            if (!$off) {
                $activity->activity = $like ? 1 : 2;
                $activity->is_del = 0;
            } else {
                $activity->is_del = 1;
            }
        }
        if ($activity !== null) {
            $activity->save();
        }
        return true;
    }*/

    private function _validate(array $data): bool
    {
        $validator = Validator::make($data, [
            'id' => 'required|integer',
            'off' => [
                'required',
                Rule::in(['true', 'false']),
            ]
        ]);
        if ($validator->fails()) {
            throw new \HttpInvalidParamException();
        }
        return true;
    }

}
