<?php

namespace App\Containers\Picture\Http\Controllers\Art;

use App\Containers\Picture\Services\RateService;
use App\Containers\Picture\Services\RateValidationService;
use App\Http\Controllers\Controller;
use App\Services\User\UserService;
use Illuminate\Http\Request;

class RateController extends Controller
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

    public function like($id, Request $request)
    {
        return $this->activity($id, $request->input('off'), true);
    }

    public function dislike($id, Request $request)
    {
        return $this->activity($id, $request->input('off'), false);
    }

    private function activity(int $artId, string $turnOff, bool $like)
    {
        $data = ['id' => $artId, 'off' => $turnOff];
        try {
            $turnOn = $turnOff !== 'true';
            $this->validateInput($data);
            $ip = (new UserService())->getIp();
            $userId = 0;
            $ratePicture = new RateService($artId, $ip, $userId);
            $like
                ? $ratePicture->like($turnOn)
                : $ratePicture->dislike($turnOn);
        } catch (\Throwable $e) {
            return response($this->_errorJsonResponse);
        }
        return response($this->_successJsonResponse);
    }

    private function validateInput(array $data): bool
    {
        if (!(new RateValidationService())->validate($data)) {
            throw new \HttpInvalidParamException();
        }
        return true;
    }

}
