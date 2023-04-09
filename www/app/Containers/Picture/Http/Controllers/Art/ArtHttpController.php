<?php

namespace App\Containers\Picture\Http\Controllers\Art;

use App\Containers\Picture\Actions\Art\GetArtAction;
use App\Containers\Picture\Exceptions\NotFoundPicture;
use App\Ship\Parents\Controllers\HttpController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Throwable;

class ArtHttpController extends HttpController
{
    /**
     * @see \App\Containers\Picture\Tests\Feature\Http\Controllers\Art\ArtHttpControllerTest
     */
    public function index(
        int $artId,
        GetArtAction $action
    ): Response {
        try {
            [$viewData, $pageMetaDto] = $action->run($artId);
            $this->setMeta($pageMetaDto->title, $pageMetaDto->description)
                ->setShareImage($pageMetaDto->shareImage)
                ->setRobots('noindex');
            return response()->view('picture::art.index', $viewData);
        } catch (NotFoundPicture $e) {
            return abort(404);
        } catch (Throwable $e) {
            Log::error($e);
            abort(500);
        }
    }
}
