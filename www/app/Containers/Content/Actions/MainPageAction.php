<?php

namespace App\Containers\Content\Actions;

use App\Containers\Seo\Tasks\GetDefaultShareImageTask;
use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Dto\PageMetaDto;
use App\Ship\Parents\Actions\Action;
use App\Ship\Services\Route\RouteService;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class MainPageAction extends Action
{
    public function __construct(
        private readonly RouteService $routeService,
        private readonly GetDefaultShareImageTask $getDefaultShareImageTask,
    ) {
    }

    /**
     * @return array{array, PageMetaDto}
     *
     * @throws UnknownProperties
     */
    public function run(): array
    {
        [$title, $description] = $this->formTitleAndDescriptionHome();
        $pageMetaDto = new PageMetaDto(
            title: $title,
            description: $description,
            shareImage: $this->getDefaultShareImageTask->run()
        );
        $alternateLinks = $this->getAlternateLinks();
        $viewData = [
            'alternateLinks' => $alternateLinks,
        ];
        return [$viewData, $pageMetaDto];
    }

    private function getAlternateLinks(): array
    {
        return [
            [
                'lang' => LangEnum::RU,
                'href' => $this->routeService->getRouteHome([], true, LangEnum::RU),
            ],
            [
                'lang' => LangEnum::EN,
                'href' => $this->routeService->getRouteHome([], true, LangEnum::EN),
            ],
        ];
    }

    private function formTitleAndDescriptionHome(): array
    {
        $title = 'Drawitbook.com - ' . __('seo.home.title');
        $description = __('seo.home.description');
        return [$title, $description];
    }
}
