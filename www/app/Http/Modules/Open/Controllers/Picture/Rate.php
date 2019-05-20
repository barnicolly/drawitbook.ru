<?php

namespace App\Http\Modules\Open\Controllers\Picture;

use App\Http\Controllers\Controller;

use App\UseCases\Picture\RatePicture;
use App\UseCases\User\GetIp;
use Illuminate\Http\Request;
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
            $ratePicture = new RatePicture($data['id'], $getIp->clean(), auth()->id());
            $ratePicture->like($data['off'] !== 'true');
        } catch (\Throwable $e) {
            return response($this->_errorJsonResponse);
        }
        return response($this->_successJsonResponse);
    }

    public function dislikeJson($id, Request $request)
    {
        $data = ['id' => $id, 'off' => $request->input('off')];
        try {
            $this->_validate($data);
            $ip = request()->ip();
            $getIp = new GetIp($ip);

            $ratePicture = new RatePicture($data['id'], $getIp->clean(), auth()->id());
            $ratePicture->dislike($data['off'] !== 'true');
        } catch (\Throwable $e) {
            return response($this->_errorJsonResponse);
        }
        return response($this->_successJsonResponse);
    }

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
