<?php

namespace App\Ship\ViewComposers;

use App\Containers\Seo\Traits\SeoTrait;
use App\Containers\Tag\Services\TagsService;
use App\Ship\Services\Route\RouteService;
use Illuminate\View\View;

class Error404Composer
{
    use SeoTrait;

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
        $this->setTitle($title)
            ->setRobots('noindex, follow');
        return $view->with($viewData);
    }
}
