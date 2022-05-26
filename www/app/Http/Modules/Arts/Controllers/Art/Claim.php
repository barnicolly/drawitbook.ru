<?php

namespace App\Http\Modules\Arts\Controllers\Art;

use App\Http\Controllers\Controller;
use App\Services\Arts\ArtsService;
use App\Services\Arts\ClaimService;
use App\Services\User\UserService;
use App\Services\Validation\CreateClaimValidationService;
use Illuminate\Http\Request;

class Claim extends Controller
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
