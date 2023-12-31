<?php

declare(strict_types=1);

namespace App\Containers\Picture\Http\Controllers\Art;

use App\Containers\Claim\Actions\CreateUserClaimIfNotExistAction;
use App\Containers\Picture\Http\Requests\Art\ClaimAjaxRequest;
use App\Ship\Parents\Controllers\HttpController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Throwable;

final class ClaimAjaxController extends HttpController
{
    /**
     * @see \App\Containers\Picture\Tests\Feature\Http\Controllers\Art\ClaimAjaxControllerTest
     */
    public function register(ClaimAjaxRequest $request, CreateUserClaimIfNotExistAction $action): JsonResponse
    {
        try {
            $action->run($request->id, $request->reason);
        } catch (Throwable $e) {
            Log::error($e);
            abort(500);
        }
        return response()->json();
    }
}
