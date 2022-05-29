<?php

namespace App\Containers\Picture\Http\Controllers\Art;

use App\Containers\Picture\Services\ArtsService;
use App\Containers\Search\Services\SearchService;
use App\Containers\Seo\Services\SeoService;
use App\Containers\Tag\Services\TagsService;
use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Parents\Controllers\HttpController;
use App\Ship\Services\Route\RouteService;

class ArtHttpController extends HttpController
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
        $this->setMeta($title, $description)
            ->setRobots('noindex');
        $primaryImage = $art['images']['primary'];
        $this->setShareImage(getArtsFolder() . $primaryImage['path']);
        return response()->view('picture::art.index', $viewData);
    }

    private function getAlternateLinks(int $id): array
    {
        $links = [];
        $links[] = [
            'lang' => LangEnum::RU,
            'href' => $this->routeService->getRouteArt($id, true, LangEnum::RU),
        ];
        $links[] = [
            'lang' => LangEnum::EN,
            'href' => $this->routeService->getRouteArt($id, true, LangEnum::EN),
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
