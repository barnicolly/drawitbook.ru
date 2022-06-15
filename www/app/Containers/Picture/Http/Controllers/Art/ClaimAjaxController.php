<?php

namespace App\Containers\Picture\Http\Controllers\Art;

use App\Containers\Claim\Service\ClaimService;
use App\Containers\Picture\Services\ArtsService;
use App\Containers\Picture\Services\CreateClaimValidationService;
use App\Containers\User\Services\UserService;
use App\Ship\Parents\Controllers\HttpController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ClaimAjaxController extends HttpController
{
    private ArtsService $artsService;

    public function __construct(ArtsService $artsService)
    {
        $this->artsService = $artsService;
    }

    /**
     * @see \App\Containers\Picture\Tests\Feature\Http\Controllers\Art\ClaimAjaxControllerTest
     */
    public function register($id, Request $request)
    {
        $data = ['id' => $id, 'reason' => $request->input('reason')];
        $result['success'] = false;
//        todo-misha вынести валидацию;
        if (!(new CreateClaimValidationService())->validate($data)) {
            return response($result, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
//        todo-misha проверить в request;
        $art = $this->artsService->isArtExist($id);
        if (!$art) {
            return response($result, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $this->createClaim($id, $data['reason']);
        $result['success'] = true;
        return response($result);
    }

    private function createClaim(int $pictureId, int $reasonId)
    {
        $ip = (new UserService())->getIp();
        $claim = (new ClaimService())->findByIpAndReasonId($pictureId, $ip, $reasonId);
        if ($claim === null) {
            (new ClaimService())->create($pictureId, $ip, $reasonId);
        }
        return true;
    }

}
