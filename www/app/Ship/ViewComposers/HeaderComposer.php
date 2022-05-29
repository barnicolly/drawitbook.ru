<?php

namespace App\Ship\ViewComposers;

use App\Containers\Menu\Services\MenuGroupService;
use Illuminate\View\View;

class HeaderComposer
{

    private $menuGroupService;

    public function __construct()
    {
        $this->menuGroupService = (new MenuGroupService());
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
