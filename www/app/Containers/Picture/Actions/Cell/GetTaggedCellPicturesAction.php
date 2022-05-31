<?php

namespace App\Containers\Picture\Actions\Cell;

use App\Containers\Picture\Exceptions\NotFoundCellArtsTagException;
use App\Containers\Picture\Exceptions\NotFoundRelativeArts;
use App\Containers\Picture\Tasks\Picture\Cell\FormCellPageAlternativeLocaleLinksTask;
use App\Containers\Picture\Tasks\Picture\Cell\GetPaginatedCellArtsByTagTask;
use App\Containers\Seo\Dto\BreadcrumbDto;
use App\Containers\Seo\Services\SeoService;
use App\Containers\Tag\Services\TagsService;
use App\Containers\Translation\Enums\LangEnum;
use App\Containers\Translation\Services\TranslationService;
use App\Ship\Dto\PageMetaDto;
use App\Ship\Parents\Tasks\Task;
use App\Ship\Services\Route\RouteService;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class GetTaggedCellPicturesAction extends Task
{

    private TranslationService $translationService;
    private RouteService $routeService;
    private TagsService $tagsService;
    private SeoService $seoService;
    private FormCellPageAlternativeLocaleLinksTask $formCellPageAlternativeLocaleLinksTask;
    private GetPaginatedCellArtsByTagTask $getPaginatedCellArtsByTagTask;

    public function __construct(
        TranslationService $translationService,
        RouteService $routeService,
        TagsService $tagsService,
        SeoService $seoService,
        FormCellPageAlternativeLocaleLinksTask $formCellPageAlternativeLocaleLinksTask,
        GetPaginatedCellArtsByTagTask $getPaginatedCellArtsByTagTask
    ) {
        $this->translationService = $translationService;
        $this->routeService = $routeService;
        $this->tagsService = $tagsService;
        $this->seoService = $seoService;
        $this->formCellPageAlternativeLocaleLinksTask = $formCellPageAlternativeLocaleLinksTask;
        $this->getPaginatedCellArtsByTagTask = $getPaginatedCellArtsByTagTask;
    }

    /**
     * @param string $tag
     * @return array<array, PageMetaDto>
     * @throws NotFoundCellArtsTagException
     * @throws NotFoundRelativeArts
     * @throws UnknownProperties
     */
    public function run(string $tag): array
    {
        $locale = app()->getLocale();
        $pageNum = 1;
        $tagInfo = $this->tagsService->getByTagSeoName($tag, $locale);
        if (!$tagInfo) {
            throw new NotFoundCellArtsTagException();
        }
        $viewData = $this->getPaginatedCellArtsByTagTask->run($tagInfo['id'], $pageNum);
        if (!$viewData['isLastSlice']) {
            $leftArtsText = $this->translationService->getPluralForm(
                $viewData['countLeftArts'],
                LangEnum::fromValue($locale)
            );
        }
        $alternateLinks = $this->formCellPageAlternativeLocaleLinksTask->run($locale, $tag, $tagInfo['id']);
        $viewData['leftArtsText'] = $leftArtsText ?? null;
        $viewData['tag'] = $tagInfo;
        $viewData['alternateLinks'] = count($alternateLinks) > 1 ? $alternateLinks : [];
        [$title, $description] = $this->seoService->formCellTaggedTitleAndDescription(
            $viewData['countRelatedArts'],
            $tagInfo['name']
        );
        $pageMetaDto = new PageMetaDto(title: $title, description: $description);
        $firstArt = Arr::first($viewData['arts']);
        if ($firstArt) {
            $pageMetaDto->shareImage = getArtsFolder() . $firstArt['images']['primary']['path'];
        }
        $breadCrumbs = new Collection();
        $breadCrumbs->push(
            new BreadcrumbDto(title: __('breadcrumbs.pixel_arts'), url: $this->routeService->getRouteArtsCell())
        );
        $breadCrumbs->push(new BreadcrumbDto(title: Str::ucfirst($tagInfo['name'])));
        $viewData['breadcrumbs'] = $breadCrumbs;
        return [$viewData, $pageMetaDto];
    }

}


