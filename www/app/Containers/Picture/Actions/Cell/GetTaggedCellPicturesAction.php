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
        $tagInfo = $this->getTagBySeoNameTask->run($tag, $locale);
        if (!$tagInfo) {
            throw new NotFoundTagException();
        }
        $paginator = $this->getPaginatedCellArtsByTagTask->run($tagInfo->id);
        $viewData['countRelatedArts'] = $paginator->total();
        $viewData['arts'] = $paginator->getCollection()->toArray();
        $viewData['countLeftArts'] = $paginator->total() - ($paginator->perPage() * $paginator->currentPage());
        $viewData['isLastSlice'] = !$paginator->hasMorePages();
        $viewData['page'] = $paginator->currentPage();

        if (!$viewData['isLastSlice']) {
            $leftArtsText = $this->translationService->getPluralForm(
                $viewData['countLeftArts'],
                LangEnum::fromValue($locale)
            );
        }
        $tagName = $tagInfo->name;
        $alternateLinks = $this->formCellPageAlternativeLocaleLinksTask->run($tagInfo);
        $viewData['leftArtsText'] = $leftArtsText ?? null;
        $viewData['tagName'] = $tagName;
        $viewData['alternateLinks'] = count($alternateLinks) > 1 ? $alternateLinks : [];
        [$title, $description] = $this->seoService->formCellTaggedTitleAndDescription(
            $viewData['countRelatedArts'],
            $tagName
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
        $breadCrumbs->push(new BreadcrumbDto(title: Str::ucfirst($tagName)));
        $viewData['breadcrumbs'] = $breadCrumbs;
        return [$viewData, $pageMetaDto];
    }

}


