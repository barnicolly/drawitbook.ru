<?php

declare(strict_types=1);

namespace App\Ship\ViewComposers;

use App\Containers\Seo\Traits\SeoTrait;
use Illuminate\View\View;

final class Error404Composer
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
