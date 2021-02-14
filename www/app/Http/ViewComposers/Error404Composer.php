<?php

namespace App\Http\ViewComposers;

use App\Services\Route\RouteService;
use App\Services\Tags\TagsService;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\View\View;

class Error404Composer
{
    private $routeService;
    private $tagsService;

    public function __construct(RouteService $routeService, TagsService $tagsService)
    {
        $this->routeService = $routeService;
        $this->tagsService = $tagsService;
    }

    public function compose(View $view)
    {
        $viewData = [];
        $title = 'Страница не найдена или была удалена';
        $viewData['incorrectUrl'] = url()->full();
        SEOTools::setTitle($title);
        SEOMeta::setRobots('noindex, follow');
        return $view->with($viewData);
    }
}
