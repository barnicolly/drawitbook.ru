<?php

namespace App\Containers\Content\Http\Controllers;

use App\Containers\Seo\Services\SeoService;
use App\Containers\Tag\Services\TagsService;
use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Parents\Controllers\HttpController;
use App\Ship\Services\Route\RouteService;

class ContentHttpController extends HttpController
{
    private $tagsService;
    private $seoService;
    private $routeService;

    public function __construct(TagsService $tagsService, SeoService $seoService, RouteService $routeService)
    {
        $this->tagsService = $tagsService;
        $this->seoService = $seoService;
        $this->routeService = $routeService;
    }

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

//    todo-misha вынести в контейнер tags;
//    todo-misha вынести в ajax контейнер;
//    todo-misha закрыть тестом;
//    todo-misha создать трансформер;
    public function tagList()
    {
        try {
            $responseList = [];
            $locale = app()->getLocale();
            $tagList = $this->tagsService->getMostPopular(40, $locale);
            foreach ($tagList as $tag) {
                $responseList[] = [
                    'link' => $this->routeService->getRouteArtsCellTagged($tag['seo']),
                    'text' => $tag['name'],
                    'weight' => $tag['count'],
                ];
            }
            $result['success'] = true;
            $result['cloud_items'] = $responseList;
            return response()->json($result);
        } catch (\Exception $e) {
            return response(['success' => false]);
        }
    }

}
