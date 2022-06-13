<?php

namespace App\Ship\ViewComposers;

use App\Containers\Menu\Services\MenuGroupService;
use Illuminate\View\View;

class HeaderComposer
{

    private MenuGroupService $menuGroupService;

    public function __construct(MenuGroupService $menuGroupService)
    {
        $this->menuGroupService = $menuGroupService;
    }

    public function compose(View $view): View
    {
        $locale = app()->getLocale();
        $viewData = [
            'groups' => $this->menuGroupService->formCategoriesGroups($locale),
        ];
        return $view->with($viewData);
    }
}
