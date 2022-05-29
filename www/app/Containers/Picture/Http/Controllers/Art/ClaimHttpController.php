<?php

namespace App\Containers\Picture\Http\Controllers\Art;

use App\Containers\Claim\Service\ClaimService;
use App\Containers\Picture\Services\ArtsService;
use App\Containers\Picture\Services\CreateClaimValidationService;
use App\Containers\User\Services\UserService;
use App\Ship\Parents\Controllers\HttpController;
use Illuminate\Http\Request;

class ClaimHttpController extends HttpController
{
    private $artsService;

    public function __construct(ArtsService $artsService)
    {
        $this->artsService = $artsService;
    }

    public function register($id, Request $request)
    {
        $data = ['id' => $id, 'reason' => $request->input('reason')];
        $result['success'] = false;
        if (!(new CreateClaimValidationService())->validate($data)) {
            return response($result);
        }
        $art = $this->artsService->isArtExist($id);
        if ($art === null) {
            return response($result);
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
