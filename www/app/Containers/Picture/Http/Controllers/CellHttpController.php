<?php

namespace App\Containers\Picture\Http\Controllers;

use App\Containers\Picture\Actions\Cell\GetCellPicturesIndexAction;
use App\Containers\Picture\Actions\Cell\GetTaggedCellPicturesAction;
use App\Containers\Picture\Exceptions\NotFoundCellArtsTagException;
use App\Containers\Picture\Exceptions\NotFoundRelativeArts;
use App\Containers\Picture\Http\Requests\Cell\CellArtsIndexRequest;
use App\Containers\Picture\Http\Requests\Cell\CellTaggedArtsRequest;
use App\Containers\Picture\Tasks\Picture\Cell\GetPaginatedCellArtsByTagTask;
use App\Containers\Tag\Services\TagsService;
use App\Containers\Tag\Tasks\FindRedirectTagSlugByLocaleTask;
use App\Containers\Translation\Enums\LangEnum;
use App\Containers\Translation\Services\TranslationService;
use App\Ship\Parents\Controllers\HttpController;
use App\Ship\Services\Route\RouteService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;
use Validator;

class CellHttpController extends HttpController
{

    private RouteService $routeService;
    private TagsService $tagsService;
    private TranslationService $translationService;

    public function __construct(
        RouteService $routeService,
        TranslationService $translationService,
        TagsService $tagsService
    ) {
        $this->routeService = $routeService;
        $this->tagsService = $tagsService;
        $this->translationService = $translationService;
    }

    public function index(GetCellPicturesIndexAction $action, CellArtsIndexRequest $request): Response
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
        CellTaggedArtsRequest $request
    ): Response|RedirectResponse {
        try {
            [$viewData, $pageMetaDto] = $action->run($tag);
            $this->setMeta($pageMetaDto->title, $pageMetaDto->description);
            if ($pageMetaDto->shareImage) {
                $this->setShareImage($pageMetaDto->shareImage);
            }
            return response()->view('picture::cell.tagged', $viewData);
        } catch (NotFoundCellArtsTagException $e) {
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

    //    todo-misha вынести в отдельный контроллер;
    public function slice(string $tag, Request $request, GetPaginatedCellArtsByTagTask $getPaginatedCellArtsByTagTask)
    {
        $rules = [
            'page' => [
                'required',
                'integer',
            ],
        ];
        //TODO-misha вынести валадацию;
        $validator = Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return abort(404);
        }
        $pageNum = (int) $request->input('page');
        try {
            $locale = app()->getLocale();
            $tagInfo = $this->tagsService->getByTagSeoName($tag, $locale);
            if (!$tagInfo) {
                throw new Exception('Не найден tag');
            }
            $viewData = $getPaginatedCellArtsByTagTask->run($tagInfo['id'], $pageNum);
            $isLastSlice = $viewData['isLastSlice'];
            if (!$isLastSlice) {
                $countLeftArtsText = $this->translationService->getPluralForm(
                    $viewData['countLeftArts'],
                    LangEnum::fromValue($locale)
                );
            }
            $result = [
                'data' => [
                    'html' => view('picture::template.stack_grid.elements', $viewData)->render(),
                    'page' => $pageNum,
                    'countLeftArtsText' => $countLeftArtsText ?? null,
                    'isLastSlice' => $isLastSlice,
                ],
            ];
        } catch (Throwable $e) {
            $result = [
                'error' => 'Произошла ошибка на стороне сервера',
            ];
        }
        return response()->json($result);
    }

}
