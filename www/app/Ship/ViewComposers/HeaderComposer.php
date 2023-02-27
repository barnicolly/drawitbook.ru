<?php

namespace App\Ship\ViewComposers;

use App\Containers\Menu\Actions\GetCachedMenuTreeAction;
use Illuminate\View\View;

class HeaderComposer
{

    private GetCachedMenuTreeAction $getCachedMenuTreeAction;

    public function __construct(GetCachedMenuTreeAction $getCachedMenuTreeAction)
    {
        $this->getCachedMenuTreeAction = $getCachedMenuTreeAction;
    }

    public function compose(View $view)
    {
        $locale = app()->getLocale();
        $viewData = [
            'groups' => $this->getCachedMenuTreeAction->run($locale),
        ];
        $view->with($viewData);
    }
}
