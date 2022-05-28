<?php

namespace App\Containers\Picture\Http\Controllers;

use App\Containers\Picture\Exceptions\NotFoundRelativeArts;
use App\Containers\Picture\Services\ArtsService;
use App\Containers\Search\Services\SearchService;
use App\Containers\Tag\Services\TagsService;
use App\Containers\Translation\Enums\LangEnum;
use App\Containers\Translation\Services\TranslationService;
use App\Http\Controllers\Controller;
use App\Http\Modules\Arts\Controllers\Exception;
use App\Services\Paginator\PaginatorService;
use App\Services\Route\RouteService;
use App\Services\Seo\SeoService;
use App\Traits\BreadcrumbsTrait;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;
use Throwable;
use Tightenco\Collect\Support\Collection as CollectionAlias;
use Validator;

class CellController extends Controller
{

    use BreadcrumbsTrait;

    private $routeService;
    private $artsService;
    private $tagsService;
    private $seoService;
    private $searchService;
    private $translationService;

    public function __construct(
        RouteService $routeService,
        ArtsService $artsService,
        SeoService $seoService,
        SearchService $searchService,
        TranslationService $translationService,
        TagsService $tagsService
    ) {
        $this->breadcrumbs = new CollectionAlias();
        $this->routeService = $routeService;
        $this->seoService = $seoService;
        $this->artsService = $artsService;
        $this->tagsService = $tagsService;
        $this->searchService = $searchService;
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
//        SEOTools::setCanonical($this->routeService->getRouteArtsCell());
        SEOTools::setTitle($title);
        $this->setShareImage(formDefaultShareArtUrlPath(true));
        SEOTools::setDescription($description);
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

    public function tagged(string $tag)
    {
        $locale = app()->getLocale();
        $pageNum = 1;
        $tagInfo = $this->tagsService->getByTagSeoName($tag, $locale);
        if (!$tagInfo) {
            $redirectSlug = $this->getRedirectSlug($locale, $tag);
            if ($redirectSlug) {
                return redirect($this->routeService->getRouteArtsCellTagged($redirectSlug), 301);
            }
            abort(404);
        }
        try {
            $viewData = $this->formViewData($tagInfo['id'], $pageNum);
        } catch (NotFoundRelativeArts $e) {
            return abort(404);
        }
        if (!$viewData['isLastSlice']) {
            $leftArtsText = $this->translationService->getPluralForm(
                $viewData['countLeftArts'],
                LangEnum::fromValue($locale)
            );
        }
        $alternateLinks = $this->formTaggedAlternateLinks($locale, $tag, $tagInfo['id']);
        $viewData['leftArtsText'] = $leftArtsText ?? null;
        $viewData['tag'] = $tagInfo;
        $viewData['alternateLinks'] = count($alternateLinks) > 1 ? $alternateLinks : [];
        $countSearchResults = $viewData['countRelatedArts'];
        $relativeArts = $viewData['arts'];
        [$title, $description] = $this->seoService->formCellTaggedTitleAndDescription(
            $countSearchResults,
            $tagInfo['name']
        );
        SEOTools::setTitle($title);
        SEOTools::setDescription($description);
//        SEOTools::setCanonical($this->routeService->getRouteArtsCellTagged($tagInfo['seo']));
        $firstArt = getFirstItemFromArray($relativeArts);
        if ($firstArt) {
            $this->setShareImage(getArtsFolder() . $firstArt['images']['primary']['path']);
        }
        $this->addBreadcrumb(__('breadcrumbs.pixel_arts'), $this->routeService->getRouteArtsCell());
        $this->addBreadcrumb(mbUcfirst($tagInfo['name']));
        $viewData['breadcrumbs'] = $this->breadcrumbs;
        return response()->view('picture::cell.tagged', $viewData);
    }

    private function formTaggedAlternateLinks(string $locale, string $initSlug, int $tagId): array
    {
        $forFormAlternateLinks[] = [
            'lang' => $locale,
            'tag' => $initSlug,
        ];
        $tagInfo = $this->tagsService->getById($tagId);
        $alternativeLang = $locale === LangEnum::RU ? LangEnum::EN : LangEnum::RU;
        $slug = $alternativeLang === LangEnum::RU
            ? $tagInfo['seo']
            : $tagInfo['slug_en'];
        if (!empty($slug)) {
            $forFormAlternateLinks[] = [
                'lang' => $alternativeLang,
                'tag' => $slug,
            ];
            $alternateLinks = $this->getTaggedAlternateLinks($forFormAlternateLinks);
        } else {
            $alternateLinks = [];
        }
        return $alternateLinks;
    }

    private function getRedirectSlug(string $locale, string $initSlug): ?string
    {
        $alternativeLang = $locale === LangEnum::RU ? LangEnum::EN : LangEnum::RU;
        if ($locale === LangEnum::RU) {
            $tagInfo = $this->tagsService->getByTagSeoName($initSlug, $alternativeLang);
        } elseif ($locale === LangEnum::EN) {
            $tagInfo = $this->tagsService->getByTagSeoName($initSlug, $alternativeLang);
        }
        if (!empty($tagInfo)) {
            $tagInfo = $this->tagsService->getById($tagInfo['id']);
            $slug = $locale === LangEnum::RU
                ? $tagInfo['seo']
                : $tagInfo['slug_en'];
            if ($slug) {
                return $slug;
            }
        }
        return null;
    }

    private function getTaggedAlternateLinks(array $forFormAlternateLinks): array
    {
        $links = [];
        foreach ($forFormAlternateLinks as $link) {
            $links[] = [
                'lang' => $link['lang'],
                'href' => $this->routeService->getRouteArtsCellTagged($link['tag'], true, $link['lang']),
            ];
        }
        return $links;
    }

    public function slice(string $tag, Request $request)
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
            $viewData = $this->formViewData($tagInfo['id'], $pageNum);
            $isLastSlice = $viewData['isLastSlice'];
            if (!$isLastSlice) {
                $countLeftArtsText = $this->translationService->getPluralForm(
                    $viewData['countLeftArts'],
                    LangEnum::fromValue($locale)
                );
            }
            $result = [
                'data' => [
                    'html' => view('Arts::template.stack_grid.elements', $viewData)->render(),
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

    private function formViewData(int $tagId, int $pageNum): array
    {
        [$relativeArtIds, $countSearchResults, $isLastSlice, $countLeftArts] = $this->formSliceArtIds(
            $tagId,
            $pageNum
        );
        if (!$relativeArtIds) {
            throw new NotFoundRelativeArts();
        }
        $relativeArts = $this->artsService->getByIdsWithTags($relativeArtIds);
        $viewData['countRelatedArts'] = $countSearchResults;
        $viewData['arts'] = $relativeArts;
        $viewData['countLeftArts'] = $countLeftArts;
        $viewData['isLastSlice'] = $isLastSlice;
        $viewData['page'] = $pageNum;
        return $viewData;
    }

    private function formSliceArtIds(int $tagId, int $pageNum): array
    {
        $relativePictureIds = $this->searchService
            ->setLimit(1000)
            ->searchByTagId($tagId);
        return (new PaginatorService())->formSlice($relativePictureIds, $pageNum);
    }

}
