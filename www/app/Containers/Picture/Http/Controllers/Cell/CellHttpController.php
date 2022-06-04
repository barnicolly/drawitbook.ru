<?php

namespace App\Containers\Picture\Http\Controllers\Cell;

use App\Containers\Picture\Actions\Cell\GetCellPicturesIndexAction;
use App\Containers\Picture\Actions\Cell\GetTaggedCellPicturesAction;
use App\Containers\Picture\Exceptions\NotFoundRelativeArts;
use App\Containers\Picture\Http\Requests\Cell\CellArtsIndexHttpRequest;
use App\Containers\Picture\Http\Requests\Cell\CellTaggedArtsHttpRequest;
use App\Containers\Tag\Exceptions\NotFoundTagException;
use App\Containers\Tag\Tasks\FindRedirectTagSlugByLocaleTask;
use App\Ship\Parents\Controllers\HttpController;
use App\Ship\Services\Route\RouteService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Throwable;

class CellHttpController extends HttpController
{

    private RouteService $routeService;

    public function __construct(
        RouteService $routeService,
    ) {
        $this->routeService = $routeService;
    }

    public function index(GetCellPicturesIndexAction $action, CellArtsIndexHttpRequest $request): Response
    {
        [$viewData, $pageMetaDto] = $action->run();
        $this->setMeta($pageMetaDto->title, $pageMetaDto->description);
        $this->setShareImage($pageMetaDto->shareImage);
        return response()->view('picture::cell.index', $viewData);
    }

    public function tagged(
        string $tag,
        GetTaggedCellPicturesAction $action,
        FindRedirectTagSlugByLocaleTask $findRedirectTagSlugByLocaleTask,
        CellTaggedArtsHttpRequest $request
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
            //            todo-misha логирование ошибок;
            abort(500);
        }
    }

}