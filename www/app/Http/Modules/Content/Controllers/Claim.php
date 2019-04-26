<?php

namespace App\Http\Modules\Content\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Database\Models\Common\Picture\PictureModel;
use App\Http\Modules\Database\Models\Common\User\UserActivityModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Validation\Rule;

class Claim extends Controller
{

    public function registerClaim($id, Request $request)
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

        $result['success'] = true;
        return response($result);
    }

    private function _validate(array $data): bool
    {
        $validator = Validator::make($data, [
            'id' => 'required|integer',
            'reason' => [
                'required',
                Rule::in(['true', 'false']),
            ]
        ]);
        return !$validator->fails();
    }

}
