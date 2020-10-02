<?php

namespace App\Http\Modules\Open\Controllers\Picture;

use App\Http\Controllers\Controller;
use App\Http\Modules\Database\Models\Common\Picture\PictureModel;
use App\Http\Modules\Database\Models\Common\User\UserClaimModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Validation\Rule;

class Claim extends Controller
{

    public function register($id, Request $request)
    {
        $data = ['id' => $id, 'reason' => $request->input('reason')];
        $result['success'] = false;
        if (!$this->_validate($data)) {
            return response($result);
        }
        $picture = PictureModel::find($data['id']);
        if ($picture === null) {
            return response($result);
        }
        $this->_register($picture->id, $data['reason']);
        $result['success'] = true;
        return response($result);
    }

    private function _register(int $pictureId, int $reasonId)
    {
        $ip = request()->ip();
        $ip = DB::connection()->getPdo()->quote($ip);
        if (Auth::check()) {
            $claim = UserClaimModel::where('reason_id', $reasonId)
                ->where('user_id', '=', auth()->id())
                ->where('picture_id', '=', $pictureId)
                ->first();
        } else {
            $claim = UserClaimModel::where('reason_id', $reasonId)
                ->whereRaw("ip = inet_aton($ip)")
                ->where('picture_id', '=', $pictureId)
                ->first();
        }
        if ($claim === null) {
            $claim = new UserClaimModel;
            $claim->picture_id = $pictureId;
            $claim->ip = DB::raw("inet_aton($ip)");
            $claim->reason_id = $reasonId;
            $claim->user_id = auth()->id();
            $claim->save();
        }
        return true;
    }

    private function _validate(array $data): bool
    {
        $validator = Validator::make($data, [
            'id' => 'required|integer',
            'reason' => [
                'required',
                Rule::in($this->_listClaimReason()),
            ]
        ]);
        return !$validator->fails();
    }

    private function _listClaimReason()
    {
        return [1, 2, 3, 4, 5];
    }

}
