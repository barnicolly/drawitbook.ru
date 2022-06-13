<?php

namespace App\Containers\Picture\Http\Controllers\Art;

use App\Containers\Picture\Services\RateService;
use App\Containers\Picture\Services\RateValidationService;
use App\Containers\User\Services\UserService;
use App\Ship\Parents\Controllers\HttpController;
use Illuminate\Http\Request;

class RateHttpController extends HttpController
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

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     *
     * @see \App\Containers\Picture\Tests\Feature\Http\Controllers\Art\RateHttpControllerLikeTest
     */
    public function like($id, Request $request)
    {
        return $this->activity($id, $request->input('off'), true);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     *
     * @see \App\Containers\Picture\Tests\Feature\Http\Controllers\Art\RateHttpControllerDislikeTest
     */
    public function dislike($id, Request $request)
    {
//        todo-misha проверить существование изображения заранее;
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
//            todo-misha переписать сервис на отдельные команды;
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
