<?php

declare(strict_types=1);

namespace App\Containers\Picture\Actions\Cell;

use App\Containers\Picture\Actions\Art\GetInterestingArtsAction;
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
    public function __construct(
        private readonly SeoService $seoService,
        private readonly RouteService $routeService,
        private readonly GetDefaultShareImageTask $getDefaultShareImageTask,
        private readonly GetInterestingArtsAction $getInterestingArtsAction,
    ) {
    }

    /**
     * @return array{array, PageMetaDto}
     *
     * @throws UnknownProperties
     */
    public function run(): array
    {
        $arts = $this->getInterestingArtsAction->run(0, 25);
        [$title, $description] = $this->seoService->formTitleAndDescriptionCellIndex();
        $pageMetaDto = new PageMetaDto(
            title: $title,
            description: $description,
            shareImage: $this->getDefaultShareImageTask->run()
        );
        $breadCrumbs = new Collection();
        $breadCrumbs->push(
            new BreadcrumbDto(title: __('breadcrumbs.pixel_arts')),
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
        return [
            [
                'lang' => LangEnum::RU,
                'href' => $this->routeService->getRouteArtsCell([], true, LangEnum::RU),
            ],
            [
                'lang' => LangEnum::EN,
                'href' => $this->routeService->getRouteArtsCell([], true, LangEnum::EN),
            ],
        ];
    }
}
