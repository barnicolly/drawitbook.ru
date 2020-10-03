<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use MetaTag;

class Error404Composer
{
    public function compose(View $view)
    {
        $title = 'Страница не найдена или была удалена';
        $viewData = [
            'incorrectUrl' => url()->full(),
        ];
        MetaTag::set('title', $title);
        return $view->with($viewData);
    }
}
