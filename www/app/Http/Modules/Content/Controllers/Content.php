<?php

namespace App\Http\Modules\Content\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Route\RouteService;
use App\Services\Seo\SeoService;
use App\Services\Tags\TagsService;
use Artesaos\SEOTools\Facades\SEOTools;

class Content extends Controller
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
        $viewData = [];
        [$title, $description] = $this->seoService->formTitleAndDescriptionHome();
        SEOTools::setTitle($title);
        $this->setShareImage(formDefaultShareArtUrlPath(true));
        SEOTools::setDescription($description);
        return response()->view('Content::main_page.index', $viewData);
    }

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
