<?php

namespace App\Containers\Picture\Http\Controllers\Art;

use App\Containers\Picture\Actions\Rate\SetLikePictureAction;
use App\Containers\Picture\Http\Requests\Art\RateAjaxRequest;
use App\Ship\Parents\Controllers\HttpController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Throwable;

class RateAjaxController extends HttpController
{
    /**
     * @see \App\Containers\Picture\Tests\Feature\Http\Controllers\Art\RateAjaxControllerLikeTest
     */
    public function like(RateAjaxRequest $request, SetLikePictureAction $action): JsonResponse
    {
        try {
            $turnOn = $request->off !== 'true';
            $action->run($request->id, $turnOn);
        } catch (Throwable $e) {
            Log::error($e);
            abort(500);
        }
        return response()->json();
    }
}
