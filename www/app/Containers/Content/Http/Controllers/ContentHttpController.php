<?php

namespace App\Containers\Content\Http\Controllers;

use App\Containers\Seo\Services\SeoService;
use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Parents\Controllers\HttpController;
use App\Ship\Services\Route\RouteService;

class ContentHttpController extends HttpController
{
    private SeoService $seoService;
    private RouteService $routeService;

    public function __construct(SeoService $seoService, RouteService $routeService)
    {
        $this->seoService = $seoService;
        $this->routeService = $routeService;
    }

//    todo-misha вынести в action + request;
    public function index()
    {
        $alternateLinks = $this->getAlternateLinks();
        $viewData = [
            'alternateLinks' => $alternateLinks,
        ];
        [$title, $description] = $this->seoService->formTitleAndDescriptionHome();
        $this->setMeta($title, $description);
        $this->setShareImage(formDefaultShareArtUrlPath(true));
        return response()->view('content::mainPage.index', $viewData);
    }

    private function getAlternateLinks(): array
    {
        $links = [];
        $links[] = [
            'lang' => LangEnum::RU,
            'href' => $this->routeService->getRouteHome([], true, LangEnum::RU),
        ];
        $links[] = [
            'lang' => LangEnum::EN,
            'href' => $this->routeService->getRouteHome([], true, LangEnum::EN),
        ];
        return $links;
    }

}
