<?php

namespace App\Containers\Picture\Actions\Cell;

use App\Containers\Picture\Services\ArtsService;
use App\Containers\Seo\Data\Dto\BreadcrumbDto;
use App\Containers\Seo\Services\SeoService;
use App\Containers\Seo\Tasks\GetDefaultShareImageTask;
use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Dto\PageMetaDto;
use App\Ship\Parents\Actions\Action;
use App\Ship\Services\Route\RouteService;
use Illuminate\Support\Collection;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class GetCellPicturesIndexAction extends Action
{
    private SeoService $seoService;
    private ArtsService $artsService;
    private RouteService $routeService;
    private GetDefaultShareImageTask $getDefaultShareImageTask;

    public function __construct(
        SeoService $seoService,
        ArtsService $artsService,
        RouteService $routeService,
        GetDefaultShareImageTask $getDefaultShareImageTask
    ) {
        $this->seoService = $seoService;
        $this->artsService = $artsService;
        $this->routeService = $routeService;
        $this->getDefaultShareImageTask = $getDefaultShareImageTask;
    }

    /**
     * @return array{array, PageMetaDto}
     * @throws UnknownProperties
     */
    public function run(): array
    {
        $arts = $this->artsService->getInterestingArts(0, 25);
        [$title, $description] = $this->seoService->formTitleAndDescriptionCellIndex();
        $pageMetaDto = new PageMetaDto(
            title: $title,
            description: $description,
            shareImage: $this->getDefaultShareImageTask->run()
        );
        $breadCrumbs = new Collection();
        $breadCrumbs->push(
            new BreadcrumbDto(title: __('breadcrumbs.pixel_arts'))
        );
        $alternateLinks = $this->getAlternateLinks();
        $viewData = [
            'arts' => $arts,
            'breadcrumbs' => $breadCrumbs,
            'alternateLinks' => $alternateLinks,
        ];
        return [$viewData, $pageMetaDto];
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

}


