<?php

namespace App\Ship\ViewComposers;

use App\Containers\Menu\Actions\GetCachedMenuTreeAction;
use Illuminate\View\View;

class HeaderComposer
{
    public function __construct(private readonly GetCachedMenuTreeAction $getCachedMenuTreeAction)
    {
    }

    public function compose(View $view): void
    {
        $locale = app()->getLocale();
        $viewData = [
            'groups' => $this->getCachedMenuTreeAction->run($locale),
        ];
        $view->with($viewData);
    }
}
