<?php

namespace App\Http\ViewComposers;

use App\Containers\Seo\Traits\SeoTrait;
use Illuminate\View\View;

class Error500Composer
{
    use SeoTrait;

    public function compose(View $view)
    {
        $title = 'Произошла ошибка на стороне сервера';
        $viewData = [];
        $this->setTitle($title);
        return $view->with($viewData);
    }
}
