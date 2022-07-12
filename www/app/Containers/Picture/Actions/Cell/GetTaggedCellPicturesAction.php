<?php

namespace App\Containers\Picture\Actions\Cell;

use App\Containers\Picture\Exceptions\NotFoundRelativeArts;
use App\Containers\Picture\Tasks\Picture\Cell\FormCellPageAlternativeLocaleLinksTask;
use App\Containers\Picture\Tasks\Picture\Cell\GetPaginatedCellArtsByTagTask;
use App\Containers\Seo\Data\Dto\BreadcrumbDto;
use App\Containers\Seo\Data\Dto\ShareImageDto;
use App\Containers\Seo\Services\SeoService;
use App\Containers\Tag\Exceptions\NotFoundTagException;
use App\Containers\Tag\Tasks\GetTagBySeoNameTask;
use App\Containers\Translation\Enums\LangEnum;
use App\Containers\Translation\Services\TranslationService;
use App\Ship\Dto\PageMetaDto;
use App\Ship\Parents\Actions\Action;
use App\Ship\Services\Route\RouteService;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class GetTaggedCellPicturesAction extends Action
{

    private TranslationService $translationService;
    private RouteService $routeService;
    private SeoService $seoService;
    private FormCellPageAlternativeLocaleLinksTask $formCellPageAlternativeLocaleLinksTask;
    private GetPaginatedCellArtsByTagTask $getPaginatedCellArtsByTagTask;
    private GetTagBySeoNameTask $getTagBySeoNameTask;

    public function __construct(
        TranslationService $translationService,
        RouteService $routeService,
        SeoService $seoService,
        FormCellPageAlternativeLocaleLinksTask $formCellPageAlternativeLocaleLinksTask,
        GetPaginatedCellArtsByTagTask $getPaginatedCellArtsByTagTask,
        GetTagBySeoNameTask $getTagBySeoNameTask
    ) {
        $this->translationService = $translationService;
        $this->routeService = $routeService;
        $this->seoService = $seoService;
        $this->formCellPageAlternativeLocaleLinksTask = $formCellPageAlternativeLocaleLinksTask;
        $this->getPaginatedCellArtsByTagTask = $getPaginatedCellArtsByTagTask;
        $this->getTagBySeoNameTask = $getTagBySeoNameTask;
    }

    /**
     * @param string $tag
     * @return array{array, PageMetaDto}
     * @throws NotFoundTagException
     * @throws NotFoundRelativeArts
     * @throws UnknownProperties
     */
    public function run(string $tag): array
    {
        $locale = app()->getLocale();
        $pageNum = 1;
        $tagInfo = $this->getTagBySeoNameTask->run($tag, $locale);
        if (!$tagInfo) {
            throw new NotFoundTagException();
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
            $image = $firstArt['images']['primary'];
            $shareImage = new ShareImageDto(
                relativePath: getArtsFolder() . $image['path'],
                width:        $image['width'],
                height:       $image['height']
            );
            $pageMetaDto->shareImage = $shareImage;
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


