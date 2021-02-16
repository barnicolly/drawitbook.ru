<?php

namespace App\Http\Modules\Arts\Controllers\Art;

use App\Enums\Lang;
use App\Http\Controllers\Controller;
use App\Services\Arts\ArtsService;
use App\Services\Route\RouteService;
use App\Services\Search\SearchService;
use App\Services\Seo\SeoService;
use App\Services\Tags\TagsService;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;

class Art extends Controller
{
    private $searchService;
    private $seoService;
    private $tagsService;
    private $artsService;
    private $routeService;

    public function __construct(
        SearchService $searchService,
        SeoService $seoService,
        TagsService $tagsService,
        ArtsService $artsService,
        RouteService $routeService
    ) {
        $this->searchService = $searchService;
        $this->seoService = $seoService;
        $this->tagsService = $tagsService;
        $this->artsService = $artsService;
        $this->routeService = $routeService;
    }

    public function index(
        int $artId
    ) {
        $art = $this->artsService->getById($artId);
        if (!$art) {
            abort(404);
        }
        $artTags = $this->tagsService->getTagsByArtId($artId, true);
        $art['tags'] = $this->prepareArtTags($artTags);
        $art = $this->seoService->setArtAlt($art);
        $alternateLinks = $this->getAlternateLinks($artId);
        $viewData = [
            'art' => $art,
            'arts' => $this->formRelativeArts($artTags, $artId),
            'popularTags' => $this->getPopularTags(),
            'alternateLinks' => $alternateLinks,
        ];
        [$title, $description] = $this->seoService->formTitleAndDescriptionShowArt($artId);
        SEOTools::setTitle($title);
        SEOTools::setDescription($description);
//        SEOTools::setCanonical($this->routeService->getRouteArt($artId));
        SEOMeta::setRobots('noindex');
        $this->setShareImage(getArtsFolder() . $art['path']);
        return response()->view('Arts::art.index', $viewData);
    }

    private function getAlternateLinks(int $id): array
    {
        $links = [];
        $links[] = [
            'lang' => Lang::RU,
            'href' => $this->routeService->getRouteArt($id, true, Lang::RU),
        ];
        $links[] = [
            'lang' => Lang::EN,
            'href' => $this->routeService->getRouteArt($id, true, Lang::EN),
        ];
        return $links;
    }

    private function formRelativeArts(array $artTags, int $artId): array
    {
        [$shown, $hidden] = $this->tagsService->separateTagsForHiddenAndShowIds($artTags);
        $arts = [];
        if ($shown || $hidden) {
            $artIds = $this->searchService->searchRelatedPicturesIds($shown, $hidden, $artId);
            if (!empty($artIds)) {
                $arts = $this->artsService->getByIdsWithTags($artIds);
            }
        }
        if (empty($arts)) {
            $arts = $this->artsService->getInterestingArts($artId, 10);
        }
        return $arts;
    }

    private function prepareArtTags(array $artTags): array
    {
        $artTags = $this->tagsService->extractNotHiddenTagsFromArt($artTags);
        return $this->tagsService->setLinkOnTags($artTags);
    }

    private function getPopularTags(): array
    {
        $locale = app()->getLocale();
        $popularTags = $this->tagsService->getPopular($locale);
        return $this->tagsService->setLinkOnTags($popularTags);
    }

}
