<?php

namespace App\Containers\Picture\Http\Controllers;

use App\Containers\Picture\Actions\Cell\GetTaggedCellPicturesAction;
use App\Containers\Picture\Exceptions\NotFoundCellArtsTagException;
use App\Containers\Picture\Exceptions\NotFoundRelativeArts;
use App\Containers\Picture\Services\ArtsService;
use App\Containers\Picture\Tasks\Picture\Cell\GetPaginatedCellArtsByTagTask;
use App\Containers\Search\Services\SearchService;
use App\Containers\Seo\Services\SeoService;
use App\Containers\Seo\Traits\BreadcrumbsTrait;
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

    use BreadcrumbsTrait;

    private RouteService $routeService;
    private ArtsService $artsService;
    private TagsService $tagsService;
    private SeoService $seoService;
    private SearchService $searchService;
    private TranslationService $translationService;

    public function __construct(
        RouteService $routeService,
        ArtsService $artsService,
        SeoService $seoService,
        TranslationService $translationService,
        TagsService $tagsService
    ) {
        //        todo-misha перенести инициализацию в trait;
        //        $this->breadcrumbs = new CollectionAlias();
        $this->routeService = $routeService;
        $this->seoService = $seoService;
        $this->artsService = $artsService;
        $this->tagsService = $tagsService;
        $this->translationService = $translationService;
    }

    public function index()
    {
        $arts = $this->artsService->getInterestingArts(0, 25);
        [$title, $description] = $this->seoService->formTitleAndDescriptionCellIndex();
        $this->addBreadcrumb(__('breadcrumbs.pixel_arts'));
        $alternateLinks = $this->getAlternateLinks();
        $viewData = [
            'arts' => $arts,
            'breadcrumbs' => $this->breadcrumbs,
            'alternateLinks' => $alternateLinks,
        ];
        $this->setMeta($title, $description);
        $this->setShareImage(formDefaultShareArtUrlPath(true));
        return response()->view('picture::cell.index', $viewData);
    }

    private function getAlternateLinks(): array
    {
        $links = [];
        $links[] = [
            'lang' => LangEnum::RU,
            'href' => $this->routeService->getRouteArtsCell([], true, LangEnum::RU),
        ];
        $links[] = [
            'lang' => LangEnum::EN,
            'href' => $this->routeService->getRouteArtsCell([], true, LangEnum::EN),
        ];
        return $links;
    }

    public function tagged(
        string $tag,
        GetTaggedCellPicturesAction $action,
        FindRedirectTagSlugByLocaleTask $findRedirectTagSlugByLocaleTask
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
