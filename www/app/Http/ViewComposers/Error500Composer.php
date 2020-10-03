<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use MetaTag;

class Error500Composer
{
    public function compose(View $view)
    {
        $title = 'Произошла ошибка на стороне сервера';
        $viewData = [];
        MetaTag::set('title', $title);
        return $view->with($viewData);
    }
}
