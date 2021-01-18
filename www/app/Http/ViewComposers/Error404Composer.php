<?php

namespace App\Http\ViewComposers;

use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\View\View;

class Error404Composer
{
    public function compose(View $view)
    {
        $title = 'Страница не найдена или была удалена';
        $viewData = [
            'incorrectUrl' => url()->full(),
        ];
        SEOTools::setTitle($title);
        SEOMeta::setRobots('noindex, follow');
        return $view->with($viewData);
    }
}
