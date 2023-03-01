<?php

namespace App\Ship\ViewComposers;

use App\Containers\Seo\Traits\SeoTrait;
use Illuminate\View\View;

class Error404Composer
{
    use SeoTrait;

    public function compose(View $view): View
    {
        $viewData = [];
        $title = 'Страница не найдена или была удалена';
        $viewData['incorrectUrl'] = url()->full();
        $this->setTitle($title)
            ->setRobots('noindex, follow');
        return $view->with($viewData);
    }
}
