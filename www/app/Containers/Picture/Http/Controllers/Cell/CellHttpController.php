<?php

namespace App\Containers\Picture\Http\Controllers\Cell;

use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Prettus\Repository\Exceptions\RepositoryException;
use App\Containers\Picture\Actions\Cell\GetCellPicturesIndexAction;
use App\Containers\Picture\Actions\Cell\GetTaggedCellPicturesAction;
use App\Containers\Picture\Exceptions\NotFoundRelativeArts;
use App\Containers\Tag\Exceptions\NotFoundTagException;
use App\Containers\Tag\Tasks\FindRedirectTagSlugByLocaleTask;
use App\Ship\Parents\Controllers\HttpController;
use App\Ship\Services\Route\RouteService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Throwable;

class CellHttpController extends HttpController
{
    public function __construct(private readonly RouteService $routeService)
    {
    }

    /**
     * @throws UnknownProperties
     *
     * @see \App\Containers\Picture\Tests\Feature\Http\Controllers\Cell\CellHttpControllerIndexTest
     */
    public function index(GetCellPicturesIndexAction $action): Response
    {
        try {
            [$viewData, $pageMetaDto] = $action->run();
            $this->setMeta($pageMetaDto->title, $pageMetaDto->description)
                ->setShareImage($pageMetaDto->shareImage);
            return response()->view('picture::cell.index', $viewData);
        } catch (Throwable $e) {
            Log::error($e);
            throw $e;
        }
    }

    /**
     * @throws RepositoryException
     *
     * @see \App\Containers\Picture\Tests\Feature\Http\Controllers\Cell\CellHttpControllerTaggedTest
     * @see \App\Containers\Picture\Tests\Feature\Http\Controllers\Cell\CellHttpControllerTaggedTestRu
     */
    public function tagged(
        string $tag,
        GetTaggedCellPicturesAction $action,
        FindRedirectTagSlugByLocaleTask $findRedirectTagSlugByLocaleTask,
    ): Response|RedirectResponse {
        try {
            [$viewData, $pageMetaDto] = $action->run($tag);
            $this->setMeta($pageMetaDto->title, $pageMetaDto->description);
            if ($pageMetaDto->shareImage) {
                $this->setShareImage($pageMetaDto->shareImage);
            }
            return response()->view('picture::cell.tagged', $viewData);
        } catch (NotFoundTagException $e) {
            $locale = app()->getLocale();
            $redirectSlug = $findRedirectTagSlugByLocaleTask->run($locale, $tag);
            if ($redirectSlug) {
                return redirect($this->routeService->getRouteArtsCellTagged($redirectSlug), 301);
            }
            return abort(404);
        } catch (NotFoundRelativeArts $e) {
            return abort(404);
        } catch (Throwable $e) {
            Log::error($e);
            throw $e;
        }
    }
}
