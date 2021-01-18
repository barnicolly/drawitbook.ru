<?php

namespace App\Http\ViewComposers;

use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\View\View;

class Error500Composer
{
    public function compose(View $view)
    {
        $title = 'Произошла ошибка на стороне сервера';
        $viewData = [];
        SEOTools::setTitle($title);
        return $view->with($viewData);
    }
}
