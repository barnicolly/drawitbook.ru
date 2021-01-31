<?php

namespace App\Http\Modules\Arts\Controllers\Art;

use App\Http\Controllers\Controller;
use App\Services\Arts\ArtsService;
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

    public function __construct(
        SearchService $searchService,
        SeoService $seoService,
        TagsService $tagsService,
        ArtsService $artsService
    ) {
        $this->searchService = $searchService;
        $this->seoService = $seoService;
        $this->tagsService = $tagsService;
        $this->artsService = $artsService;
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
        $viewData = [
            'art' => $art,
            'arts' => $this->formRelativeArts($artTags, $artId),
            'popularTags' => $this->getPopularTags(),
        ];
        [$title, $description] = $this->seoService->formTitleAndDescriptionShowArt($artId);
        SEOTools::setTitle($title);
        SEOTools::setDescription($description);
        SEOMeta::setRobots('noindex');
        $this->setShareImage(getArtsFolder() . $art['path']);
        return response()->view('Arts::art.index', $viewData);
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
